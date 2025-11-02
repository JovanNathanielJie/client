<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

// Halaman welcome/login
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Login GET → redirect ke welcome
Route::get('/login', function () {
    return redirect('/');
});

// Login POST → proses login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout (opsional)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Spotify
Route::get('/dashboard', [SpotifyController::class, 'dashboard'])
    ->name('dashboard.index');

Route::get('/postcards/encouragement', function () {
    return view('postcards.encouragement');
});

Route::get('/postcards/love', function () {
    return view('postcards.love');
});

Route::get('/postcards/light', function () {
    return view('postcards.light');
});

Route::get('/postcards/affection', function () {
    return view('postcards.affection');
});

Route::get('/playlist', function()  {
    return view('playlist.playlist');
});

Route::get('/countdown', function () {
    return view('countdown.countdown');
});

Route::get('/message', function () {
    return view('message.message');
});

Route::get('/biography', function () {
    return view('biography.bio');
});

Route::get('/gallery', function () {
    return view('gallery.gallery');
});

Route::get('/api/spotify/tracks', function () {
    $clientId = env('SPOTIFY_CLIENT_ID');
    $clientSecret = env('SPOTIFY_CLIENT_SECRET');

    // Ambil token
    $tokenResponse = Http::asForm()->post('https://accounts.spotify.com/api/token', [
        'grant_type' => 'client_credentials',
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
    ]);
    $accessToken = $tokenResponse['access_token'];

    // Playlist kamu
    $playlistId = '38QnPhHZa2umQm45xPTo1H';
    $response = Http::withToken($accessToken)
        ->get("https://api.spotify.com/v1/playlists/$playlistId/tracks");

    $tracks = collect($response['items'])
        ->filter(fn($item) => isset($item['track']['preview_url']))
        ->map(fn($item) => [
            'name' => $item['track']['name'],
            'artist' => $item['track']['artists'][0]['name'],
            'preview_url' => $item['track']['preview_url'],
        ])
        ->values();

    return response()->json($tracks);
});
