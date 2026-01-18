<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/game/song-data', [GameController::class, 'getSongData']);
