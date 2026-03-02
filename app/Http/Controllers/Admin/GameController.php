<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Exception;
use Flux\Flux;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.game.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.game.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:games,name',
            'publisher' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5100',
            'status' => 'required',
        ]);

        try {

            $format = $request->file('image')->getClientOriginalExtension();
            $name = uniqid() . '.' . $format;
            $path = $request->file('image')->storeAs('games', $name, 'public');

            Game::create([
                'name' => $request->name,
                'publisher' => $request->publisher,
                'image' => $path,
                'status' => $request->status,
            ]);
            
            return redirect()->route('admin.game.index');
        } catch (Exception $e) {
            return redirect()->back()->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Game::find($id);
        return view('pages.admin.game.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:games,name,' . $id,
            'publisher' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5100',
            'status' => 'required',
        ]);

       try {
         if ($request->hasFile('image')) {
            $game = Game::find($id);
            Storage::disk('public')->delete($game->image);

            $format = $request->file('image')->getClientOriginalExtension();
            $name = uniqid() . '.' . $format;
            $path = $request->file('image')->storeAs('games', $name, 'public');

            $game->update([
                'name' => $request->name,
                'publisher' => $request->publisher,
                'image' => $path,
                'status' => $request->status,
            ]);
            
        } else {
            $game = Game::find($id);
            $game->update([
                'name' => $request->name,
                'publisher' => $request->publisher,
                'status' => $request->status,
            ]);
            
        }

        return redirect()->route('admin.game.index');
       } catch (Exception $e) {
        return redirect()->back()->withInput();
       }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::where('id', $id)->first();

        Storage::disk('public')->delete($game->image);
        $game->delete();
        return redirect()->route('admin.game.index');
    }
}
