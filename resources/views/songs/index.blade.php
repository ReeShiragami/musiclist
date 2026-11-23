@extends('layouts.app')
@section('title', 'Daftar Lagu')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <h1 style="margin:0; font-size:20px;">
            Lagu yang kudengarkan
            <span class="counter">{{ $totalSongs }}</span>
        </h1>
        <a class="btn btn-primary" href="{{ route('songs.create') }}">Tambah lagu</a>
    </div>

    @if ($tags->isNotEmpty())
        <div style="margin-bottom:16px;">
            <a class="tag {{ $tag ? '' : 'active' }}" href="{{ route('songs.index') }}">semua</a>
            @foreach ($tags as $t)
                <a class="tag {{ $tag === $t ? 'active' : '' }}"
                   href="{{ route('songs.index', ['tag' => $t]) }}">{{ $t }}</a>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-head">
            <span class="meta">
                @if ($tag)
                    {{ $songs->total() }} lagu dengan tag "{{ $tag }}"
                @else
                    Menampilkan {{ $songs->count() }} dari {{ $totalSongs }} lagu
                @endif
            </span>
        </div>

        @forelse ($songs as $song)
            <div class="row">
                <h3>
                    @if ($song->link)
                        <a href="{{ $song->link }}" target="_blank" rel="noopener">{{ $song->title }}</a>
                    @else
                        {{ $song->title }}
                    @endif
                </h3>
                <div class="meta">
                    {{ $song->artist }}
                    @if ($song->reference)
                        · dari <em>{{ $song->reference }}</em>
                    @endif
                </div>
                <div style="margin-top:8px; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        @foreach ($song->tags() as $t)
                            <a class="tag" href="{{ route('songs.index', ['tag' => $t]) }}">{{ $t }}</a>
                        @endforeach
                    </div>
                    <div style="display:flex; gap:8px;">
                        <a class="btn" href="{{ route('songs.edit', $song) }}">Edit</a>
                        <form method="POST" action="{{ route('songs.destroy', $song) }}"
                              onsubmit="return confirm('Hapus {{ $song->title }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty">Belum ada lagu di sini.</div>
        @endforelse
    </div>

    <div style="margin-top:16px;">
        {{ $songs->links() }}
    </div>
@endsection