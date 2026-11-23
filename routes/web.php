<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;

Route::redirect('/', '/songs');
Route::resource('songs', SongController::class)->except('show');
