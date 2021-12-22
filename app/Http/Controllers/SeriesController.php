<?php

namespace App\Http\Controllers;

use App\Models\Series;
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
        $latest = Series::orderBy('created_at', 'desc')->take(9)->get();
        return view('series.show', compact('series', 'latest'));
    }
}
