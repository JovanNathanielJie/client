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

Route::get('/guess', function () {
    return view('guess.guess');
});

Route::get('/countdown', function () {
    return view('countdown.countdown');
});

Route::get('/message', function () {
    return view('message.message');
});

Route::get('/api/spotify/tracks', function () {
    $clientId = env('SPOTIFY_CLIENT_ID');
    $clientSecret = env('SPOTIFY_CLIENT_SECRET');

    // Cek cache token (biar gak minta token terus)
    $token = Cache::get('spotify_token');

    if (!$token) {
        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret"),
        ])->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
        ]);

        $token = $response->json()['access_token'] ?? null;
        if (!$token) {
            return response()->json(['error' => 'Failed to get token'], 500);
        }

        Cache::put('spotify_token', $token, now()->addMinutes(55)); // Token 1 jam
    }

    // Ambil tracks dari playlist kamu
    $playlistId = '38QnPhHZa2umQm45xPTo1H';
    $result = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get("https://api.spotify.com/v1/playlists/$playlistId/tracks");

    $tracks = collect($result->json()['items'] ?? [])
        ->map(fn($item) => $item['track'])
        ->filter(fn($track) => !empty($track['preview_url']))
        ->map(fn($track) => [
            'name' => $track['name'],
            'artist' => collect($track['artists'])->pluck('name')->join(', '),
            'preview_url' => $track['preview_url'],
        ])
        ->values();

    return response()->json($tracks);
});
