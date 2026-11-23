@extends('layouts.app')
@section('title', 'Tambah Lagu')

@section('content')
    <h1 style="font-size:20px;">Tambah lagu</h1>

    <form method="POST" action="{{ route('songs.store') }}">
        @csrf
        @include('songs._form')

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('songs.index') }}">Batal</a>
        </div>
    </form>
@endsection