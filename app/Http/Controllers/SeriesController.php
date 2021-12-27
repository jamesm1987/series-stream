<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::orderBy('created_at', 'desc')->paginate(18);
        return view('series.index', compact('series'));
    }
    
    public function show(Series $series)
    {
        $latests = Series::orderBy('created_at', 'desc')->take(9)->get();
        return view('series.show', compact('series', 'latests'));
    }

    public function seasonShow(Series $series, Season $season)
    {
        $latests = Season::withCount('episodes')->orderBy('created_at', 'desc')->take(9)->get();
      
        return view('series.seasons.show', compact('series', 'season', 'latests'));
    }


    public function showEpisode(Episode $episode)
    {
        $data = [
            'show' => $episode->season->series->name,
            'season' => $episode->season->season_number,
            'episode' => $episode->episode_number,
            'url' => $episode->getVideo()
        ];


        $latests = Episode::orderBy('created_at', 'desc')->take(9)->get();
        return view('player.index', compact('data', 'latests'));
    }
}
