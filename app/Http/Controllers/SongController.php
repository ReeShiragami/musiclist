<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->query('tag');

        $sortable = ['artist', 'reference'];
        $sort = in_array($request->query('sort'), $sortable, true) ? $request->query('sort') : null;
        $dir  = $request->query('dir') === 'desc' ? 'desc' : 'asc';

        $songs = Song::query()
            ->when($tag, function ($query) use ($tag) {
                $query->where(function ($q) use ($tag) {
                    $q->where('tag1', $tag)->orWhere('tag2', $tag);
                });
            })
            ->when(
                $sort,
                fn ($query) => $query->orderBy($sort, $dir)->orderBy('title'),
                fn ($query) => $query->latest()
            )
            ->paginate(15)
            ->withQueryString();

        $totalSongs = Song::count();

        $tags = Song::pluck('tag1')
            ->merge(Song::whereNotNull('tag2')->pluck('tag2'))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('songs.index', compact('songs', 'totalSongs', 'tags', 'tag', 'sort', 'dir'));
    }
    public function create()
    {
        return view('songs.create', ['song' => new Song()]);
    }

    public function store(SongRequest $request)
    {
        Song::create($request->validated());

        return redirect()
            ->route('songs.index')
            ->with('status', 'Lagu berhasil ditambahkan.');
    }

    public function edit(Song $song)
    {
        return view('songs.edit', compact('song'));
    }

    public function update(SongRequest $request, Song $song)
    {
        $song->update($request->validated());

        return redirect()
            ->route('songs.index')
            ->with('status', 'Lagu berhasil diperbarui.');
    }

    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()
            ->route('songs.index')
            ->with('status', 'Lagu dihapus.');
    }
}