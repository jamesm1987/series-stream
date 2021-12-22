<?php
namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $series = Series::orderBy('created_at', 'desc')->take(12)->get();
        $episodes = Episode::orderBy('created_at', 'desc')->take(12)->get();

        return view('welcome', compact('series', 'episodes'));
    }
}