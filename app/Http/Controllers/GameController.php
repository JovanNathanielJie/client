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
        return view('game.guess-the-song');
    }

    public function getSongData(Request $request)
    {
        try {
            $playlistId = $request->input('playlist_id', '38QnPhHZa2umQm45xPTo1H');

            $accessToken = $this->getAccessToken();

            // Fetch all tracks from playlist
            $tracksRes = Http::withToken($accessToken)->get(
                "https://api.spotify.com/v1/playlists/{$playlistId}/tracks",
                [
                    'limit'  => 50,
                    'fields' => 'items(track(id,name,artists(name)))',
                ]
            );

            if ($tracksRes->failed()) {
                return response()->json(['error' => 'Spotify API failed: ' . $tracksRes->status()], 400);
            }

            $tracksData = $tracksRes->json('items') ?? [];

            if (empty($tracksData)) {
                return response()->json(['error' => 'Playlist is empty'], 400);
            }

            // Get lyrics for each track
            $items = collect($tracksData)
                ->filter(function($i) {
                    return isset($i['track']) && !empty($i['track']);
                })
                ->map(function($item) {
                    $track = $item['track'];
                    $trackName = $track['name'];
                    $artist = $track['artists'][0]['name'] ?? 'Unknown';

                    // Try to get lyrics
                    $lyrics = $this->getLyrics($artist, $trackName);

                    return [
                        'id' => $track['id'],
                        'name' => $trackName,
                        'artist' => $artist,
                        'lyrics' => $lyrics,
                    ];
                })
                ->filter(fn($item) => !empty($item['lyrics'])) // Only songs with lyrics
                ->values()
                ->toArray();

            if (empty($items)) {
                return response()->json(['error' => 'No songs with lyrics found'], 400);
            }

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getLyrics($artist, $title)
    {
        try {
            // Clean up artist and title for API
            $artist = trim($artist);
            $title = trim($title);

            // Try lyrics.ovh API
            $response = Http::timeout(5)->get('https://api.lyrics.ovh/v1/' . urlencode($artist) . '/' . urlencode($title));

            if ($response->successful() && isset($response['lyrics'])) {
                $fullLyrics = $response['lyrics'];
                // Get first 3-4 lines
                $lines = array_filter(explode("\n", $fullLyrics));
                $snippet = implode("\n", array_slice($lines, 0, 4));
                return $snippet ?: null;
            }
        } catch (\Exception $e) {
            // Silently fail, will be filtered out
        }

        return null;
    }
}
