<?php

namespace App\Http\Controllers;

use Dymantic\InstagramFeed\Profile;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

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
    
    public function complete(Request $request)
    {
        return redirect()->route('instagram');
    }


    public function deauth(Request $request)
    {
        Log::debug($request);
    }


}
