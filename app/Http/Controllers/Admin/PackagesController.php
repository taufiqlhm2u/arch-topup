<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.package.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $games = Game::all();
        return view('pages.admin.package.create', compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $format = $request->file('image')->getClientOriginalExtension();
            $name = uniqid() . '.' . $format;
            $path = $request->file('image')->storeAs('packages', $name, 'public');
            Package::create([
                'game_id' => $request->game_id,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'image' => $path,
            ]);

            return redirect()->route('admin.paket.index')->with('success', '');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        $item = Package::find($id);
        $games = Game::all();
        return view('pages.admin.package.edit', compact('item', 'games'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'game_id' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $package = Package::find($id);
            $path = $package->image;
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($package->image);
                $file = $request->file('image');
                $name = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('image')->storeAs('packages', $name, 'public');
            }


            $package->game_id = $request->game_id;
            $package->type = $request->type;
            $package->quantity = $request->quantity;
            $package->price = $request->price;
            $package->image = $path;
            $package->save();

            return redirect()->route('admin.paket.index')->with('success', '');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Package::find($id);
        Storage::disk('public')->delete($item->image);
        $item->delete();
        return redirect()->route('admin.paket.index')->with('success', '');
    }
}
