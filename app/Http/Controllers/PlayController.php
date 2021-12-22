<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;

class PlayController extends Controller
{
    public function __invoke(Request $request)
    {
        $episode_id = $request->route('episode');

        $episode = Episode::find($episode_id);
        $data = [
            'show' => $episode->season->series->name,
            'season' => $episode->season->season_number,
            'episode' => $episode->episode_number,
            'url' => $episode->stream->url
        ];

        return view('player.index', [
            'data' => $data
        ]);

    }
}
