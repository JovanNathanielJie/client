<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    private function getAccessToken()
    {
        $clientId = env('SPOTIFY_CLIENT_ID');
        $clientSecret = env('SPOTIFY_CLIENT_SECRET');

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            throw new \Exception("Gagal mendapatkan access token Spotify: " . $response->body());
        }

        return $response->json()['access_token'];
    }

    public function guessTheSong()
    {
        if (!session()->has('user_name')) {
            return redirect('/');
        }

        return view('game.guess-the-song');
    }

    public function getSongData(Request $request)
    {
        $playlistId = $request->input('playlist_id', '38QnPhHZa2umQm45xPTo1H'); // Default playlist

        try {
            $accessToken = $this->getAccessToken();

            // Fetch all tracks from playlist
            $tracksRes = Http::withToken($accessToken)->get(
                "https://api.spotify.com/v1/playlists/{$playlistId}/tracks",
                [
                    'limit'  => 50,
                    'fields' => 'items(track(id,name,preview_url,duration_ms,artists(name),album(images)))',
                ]
            );

            if ($tracksRes->failed()) {
                return response()->json(['error' => 'Failed to fetch tracks'], 400);
            }

            $items = collect($tracksRes->json('items'))
                ->filter(fn($i) => !empty($i['track']) && !empty($i['track']['preview_url']))
                ->map(function($item) {
                    $track = $item['track'];
                    return [
                        'id' => $track['id'],
                        'name' => $track['name'],
                        'artists' => implode(', ', array_map(fn($a) => $a['name'], $track['artists'])),
                        'preview_url' => $track['preview_url'],
                        'image' => $track['album']['images'][0]['url'] ?? null,
                    ];
                })
                ->values()
                ->toArray();

            if (empty($items)) {
                return response()->json(['error' => 'No playable songs found'], 400);
            }

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
