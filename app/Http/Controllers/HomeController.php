<?php

namespace App\Http\Controllers;

use App\Models\Game;


class HomeController extends Controller
{
    public function index()
    {
        $games = Game::limit(6)->get();
        return view('pages.user.home', compact('games'));
    }
}
