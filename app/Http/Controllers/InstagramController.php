<?php

namespace App\Http\Controllers;

use Dymantic\InstagramFeed\Profile;

use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('instagram.index', ['profiles' => $profiles ]);
    }

    public function store(Request $request)
    {
        $profile = Profile::create(['username' => $request->username]);

        return redirect()->route('instagram')->with(['profile' => $profile]);
    }
}
