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
            \Log::info('Game API - Fetching songs for playlist: ' . $playlistId);

            $accessToken = $this->getAccessToken();
            \Log::info('Game API - Got access token');

            // Fetch all tracks from playlist
            $tracksRes = Http::withToken($accessToken)->get(
                "https://api.spotify.com/v1/playlists/{$playlistId}/tracks",
                [
                    'limit'  => 50,
                    'fields' => 'items(track(id,name,preview_url,duration_ms,artists(name),album(images)))',
                ]
            );

            \Log::info('Game API - Response status: ' . $tracksRes->status());

            if ($tracksRes->failed()) {
                $errorMsg = 'Spotify API Error: ' . $tracksRes->status() . ' - ' . $tracksRes->body();
                \Log::error($errorMsg);
                return response()->json(['error' => $errorMsg], 400);
            }

            $tracksData = $tracksRes->json('items');
            \Log::info('Game API - Got ' . count($tracksData ?? []) . ' items from Spotify');

            if (!$tracksData) {
                return response()->json(['error' => 'No items in playlist'], 400);
            }

            $items = collect($tracksData)
                ->filter(function($i) {
                    return isset($i['track']) &&
                           !empty($i['track']) &&
                           isset($i['track']['preview_url']) &&
                           !empty($i['track']['preview_url']);
                })
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

            \Log::info('Game API - Filtered to ' . count($items) . ' playable songs');

            if (empty($items)) {
                return response()->json(['error' => 'No playable songs found in playlist (songs need preview URLs)'], 400);
            }

            return response()->json($items);
        } catch (\Exception $e) {
            $errorMsg = 'Game Controller Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine();
            \Log::error($errorMsg);
            return response()->json(['error' => $errorMsg], 500);
        }
    }
}
