<?php

namespace App\Http\Controllers\Admin\PlaylistComposer;

use App\Http\Controllers\Controller;
use App\Models\Playlist;

class PlaylistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function store()
    {
        Playlist::create([
            'mode' => request()->mode,
            'name' => request()->name,
            'season_id' => request()->season_id,
        ]);

        return redirect()->back();
    }
}
