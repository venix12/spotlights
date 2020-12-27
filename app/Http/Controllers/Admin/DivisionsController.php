<?php

namespace App\Http\Controllers\Admin;

use App\Models\Division;
use App\Http\Controllers\Controller;

class DivisionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create($season_id)
    {
        return view('admin.leaderboards.create-division')
            ->with('id', $season_id);
    }

    public function edit($id)
    {
        $division = Division::find($id);

        return view('admin.leaderboards.edit-division')
            ->with('division', $division);
    }

    public function loadDefaults($season_id)
    {
        foreach (default_divisions() as $default) {
            Division::create([
                'absolute' => $default['absolute'],
                'display' => $default['display'],
                'name' => $default['name'],
                'season_id' => $season_id,
                'threshold' => $default['threshold'],
            ]);
        }

        return redirect(route('admin.seasons.show', $season_id));
    }

    public function store($season_id)
    {
        $currentDivision = Division::where('season_id', $season_id)
            ->where('name', request()->name);

        if ($currentDivision->exists()) {
            return redirect(route('admin.seasons.show', $season_id));
        } else {
            Division::create([
                'absolute' => request()->absolute ? true : false,
                'display' => request()->display,
                'name' => request()->name,
                'season_id' => $season_id,
                'threshold' => request()->threshold,
            ]);
        }

        return redirect(route('admin.seasons.show', $season_id));
    }

    public function update($id)
    {
        $division = Division::find($id);

        $division->update([
            'absolute' => request()->absolute ? true : false,
            'display' => request()->display,
            'name' => request()->name,
            'threshold' => request()->threshold,
        ]);

        return redirect(route('admin.seasons.show', $division->season->id));
    }

    public function remove($id)
    {
        $factor = Division::find($id);

        $factor->delete();

        return redirect()->back();
    }
}
