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
    
    public function delete(Request $request, $id)
    {
    
        $profile = Profile::where('id', $id)->get();
        
        if ( count($profile) > 0)  {
            $profile->each->clearToken();
            $profile->each->delete();
        }

        return redirect()->route('instagram');
    }
    
    public function complete(Request $request)
    {
        return redirect()->route('instagram');
    }

    public function deauth(Request $request)
    {
        Log::debug('Instagram Profile {{$profile->id }} removed authentication initiated');
        $signed_request = $this->parse_signed_request($request->signed_request);
        
        $user_id = $signed_request->user_id;

        $profile = Profile::where('user_id', $user_id)->get();

        if ( count($profile) > 0)  {
            $profile->each->clearToken();
            $profile->each->delete();
        }

        Log::debug('Instagram Profile {{$profile->id }} removed authentication');

    }

    private function parse_signed_request($signed_request)
    {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
    
        // Use your app secret here
        $secret = env('INSTAGRAM_CLIENT_SECRET');
    
        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);
    
        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            Log::debug('Bad Signed JSON signature!');
            return null;
        }
    
        return $data;
          
    }  
    
    private function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));     
    }
}
