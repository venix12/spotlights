<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Season;

class SeasonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create()
    {
        return view('admin.leaderboards.create-season');
    }

    public function index()
    {
        $seasons = Season::all();

        return view('admin.leaderboards.index')
            ->with('seasons', $seasons);
    }

    public function show($id)
    {
        $season = Season::findOrFail($id);

        return view('admin.leaderboards.show')
            ->with('season', $season);
    }

    public function store()
    {
        Season::create([
            'name' => request()->name,
        ]);

        redirect(route('admin.seasons'));
    }
}
