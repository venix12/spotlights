<?php

namespace App\Http\Controllers\Admin\PlaylistComposer;

use App\Http\Controllers\Controller;
use App\Models\Season;

class SeasonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_team_leader');
    }

    public function index()
    {
        $seasons = Season::all();

        return view('admin.playlist-composer.index')
            ->with('seasons', $seasons);
    }

    public function show($id)
    {
        $season = Season::findOrFail($id)
            ->with('playlists')
            ->with('playlists.entries')
            ->first();

        $validationErrors = $season->validate();

        return view('admin.playlist-composer.show')
            ->with('season', $season)
            ->with('validationErrors', $validationErrors);
    }

    public function store()
    {
        Season::create([
            'name' => request()->name,
        ]);

        return redirect()->back();
    }
}