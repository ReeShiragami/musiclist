<?php

namespace App\Console\Commands;

use App\Http\Requests\SongRequest;
use App\Models\Song;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ImportSongs extends Command
{
    protected $signature = 'songs:import
                            {path=database/data/songs.csv : Lokasi file CSV}
                            {--delimiter=, : Pemisah kolom, pakai ";" untuk CSV dari Excel Indonesia}
                            {--dry-run : Cek saja, tidak menyimpan apa pun}';

    protected $description = 'Impor banyak lagu sekaligus dari file CSV';

    public function handle(): int
    {
        $path      = base_path($this->argument('path'));
        $delimiter = $this->option('delimiter');
        $dryRun    = $this->option('dry-run');

        if (! is_file($path)) {
            $this->error("File tidak ditemukan: {$path}");
            return self::FAILURE;
        }

        $handle = fopen($path, 'r');

        // Baca header, buang karakter BOM yang kadang ditambahkan Excel
        $header = fgetcsv($handle, 0, $delimiter, '"', '\\');
        $header = array_map(
            fn ($h) => strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $h))),
            $header
        );

        $missing = array_diff(['title', 'artist', 'tag1', 'tag2', 'reference', 'link'], $header);
        if ($missing) {
            $this->error('Header kurang: ' . implode(', ', $missing));
            $this->line('Kalau header sudah benar tapi tetap error, coba tambahkan --delimiter=";"');
            fclose($handle);
            return self::FAILURE;
        }

        // Tahap 1: baca dan validasi SEMUA baris dulu
        $rules  = (new SongRequest())->rules();
        $rows   = [];
        $errors = [];
        $line   = 1;

        while (($data = fgetcsv($handle, 0, $delimiter, '"', '\\')) !== false) {
            $line++;

            if ($data === [null]) {
                continue; // baris kosong
            }

            $data = array_slice(array_pad($data, count($header), null), 0, count($header));
            $row  = array_combine($header, $data);
            $row  = array_map(fn ($v) => ($v = trim((string) $v)) === '' ? null : $v, $row);

            $validator = Validator::make($row, $rules);

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $errors[] = "Baris {$line}: {$message}";
                }
                continue;
            }

            $rows[] = $validator->validated();
        }

        fclose($handle);

        // Kalau ada yang salah, batalkan semuanya
        if ($errors) {
            foreach ($errors as $e) {
                $this->error($e);
            }
            $this->error('Dibatalkan. Tidak ada lagu yang disimpan, perbaiki CSV lalu jalankan lagi.');
            return self::FAILURE;
        }

        // Tahap 2: simpan, lewati lagu yang sudah ada
        $added = 0;
        $skipped = 0;

        DB::transaction(function () use ($rows, $dryRun, &$added, &$skipped) {
            foreach ($rows as $row) {
                $exists = Song::where('title', $row['title'])
                    ->where('artist', $row['artist'])
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                if (! $dryRun) {
                    Song::create($row);
                }
                $added++;
            }
        });

        $this->info(($dryRun ? '[DRY RUN] ' : '') . "Selesai. Ditambahkan: {$added}, dilewati (sudah ada): {$skipped}");

        return self::SUCCESS;
    }
}