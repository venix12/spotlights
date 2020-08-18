<?php

namespace App\Http\Controllers\Admin;

use App\Division;
use App\Http\Controllers\Controller;

class DivisionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create($id)
    {
        return view('admin.leaderboards.create-division')
            ->with('id', $id);
    }

    public function store($id)
    {
        $currentDivision = Division::where('season_id', $id)
            ->where('name', request()->name)
            ->first();

        if ($currentDivision === null) {
            Division::create([
                'absolute' => request()->absolute ? true : false,
                'name' => request()->name,
                'season_id' => $id,
                'threshold' => request()->threshold,
            ]);
        } else {
            $currentDivision->update([
                'threshold' => request()->threshold,
            ]);
        }

        return redirect(route('admin.seasons.show', $id));
    }
}
