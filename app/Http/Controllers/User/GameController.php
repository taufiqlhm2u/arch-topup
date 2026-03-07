<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\Package;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return view('pages.user.game.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Game::find($id)) {
            return redirect()->route('game.index');
        }
        $packages = Package::where('game_id', $id)->get();
        $game = Game::find($id);
        $types = $packages->pluck('type')->unique();
        return view('pages.user.game.show', compact('packages', 'game', 'types'));
    }

    public function search(string $q = null)
    {
        if ($q) {
            $search = $q;
            $games = Game::whereRaw("LOWER(name) LIKE ?", ['%' . strtolower($search) . '%'])->get();
            return view('pages.user.game.search', compact('games', 'search'));
        } else {
            return redirect()->route('game.index');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
