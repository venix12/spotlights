<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LeaderboardFactor;

class FactorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create($season_id)
    {
        return view('admin.leaderboards.create-factor')
            ->with('id', $season_id);
    }

    public function edit($id)
    {
        $factor = LeaderboardFactor::find($id);

        return view('admin.leaderboards.edit-factor')
            ->with('factor', $factor);
    }

    public function store($season_id)
    {
        LeaderboardFactor::create([
            'factor' => request()->factor,
            'season_id' => $season_id,
        ]);

        return redirect(route('admin.seasons.show', $season_id));
    }

    public function update($id)
    {
        $factor = LeaderboardFactor::find($id);

        $factor->update([
            'factor' => request()->factor,
        ]);

        return redirect(route('admin.seasons.show', $factor->season->id));
    }

    public function remove($id)
    {
        $factor = LeaderboardFactor::find($id);

        $factor->delete();

        return redirect()->back();
    }
}
