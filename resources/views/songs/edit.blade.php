@extends('layouts.app')
@section('title', 'Edit Lagu')

@section('content')
    <h1 style="font-size:20px;">Edit lagu</h1>

    <form method="POST" action="{{ route('songs.update', $song) }}">
        @csrf
        @method('PUT')
        @include('songs._form')

        <div class="actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('songs.index') }}">Batal</a>
        </div>
    </form>
@endsection