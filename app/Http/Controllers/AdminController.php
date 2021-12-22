<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $series =Series::all();
        return view('admin.index', compact('users', 'series'));
    }
}