<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TrackController extends Controller
{

    //TODO: Implementacion de la busqueda de canciones por id de deezer
    public function findByIdDeezer($id)
    {
        //NOTE: Busqueda en la base de datos
        $track = Track::where('deezer_id', $id)->first();

        //NOTE: Si no se encuentra en la base de datos se busca en la api de deezer
        if (!$track) {
            $url = config('services.deezer.base_url') . 'track/' . $id;
            $response = Http::get($url);

            if ($response->failed()) {
                return response()->json([
                    'status' => 'Track not found',
                    'message' => 'Track not found',
                ], 404);
            }

            $data = $response->json();
            //NOTE: Se crea el registro en la base de datos
            $track = Track::create([
                'deezer_id' => $data['id'],
                'youtube_id' => '',
                'title' => $data['title'],
                'title_short' => $data['title_short'],
                'duration' => $data['duration'],
                'position' => $data['track_position'],
                'disk_number' => $data['disk_number'],
                'release_date' => $data['release_date'],
                'preview' => $data['preview'],
                'md5_image' => 'https://e-cdns-images.dzcdn.net/images/cover/' . $data['md5_image'] . '/250x250-000000-80-0-0.jpg',
                'searchable' => $data['title_short'] . ' ' . $data['title_version'] . ' ' . $data['artist']['name'],
            ]);
            //NOTE: Se busca en youtube
            $youtube = $this->searchYoutube($track->searchable);

            if ($youtube) {
                $track->youtube_id = $youtube['items'][0]['id']['videoId'];
                $track->save();
            } else {
                $track->delete();
                return response()->json([
                    'status' => 'Track not found',
                    'message' => 'Track not found',
                ], 404);
            }
        }

        return response()->json([
            'status' => 'Track found',
            'message' => 'Track found successfully',
            'data' => $track,
        ], 200);
    }

    // TODO: Implementacion de la busqueda de canciones en youtube
    private function searchYoutube($query)
    {
        $url = config('services.youtube.base_url') . 'search';
        $params = [
            'part' => 'id, snippet',
            'maxResults' => 1,
            'key' => config('services.youtube.key'),
            'type' => 'video',
            'q' => $query,
        ];

        $response = Http::get($url, $params);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
