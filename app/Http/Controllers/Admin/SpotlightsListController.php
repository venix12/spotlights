<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spotlights;

class SpotlightsListController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin_or_manager');
    }

    public function index()
    {
        $spotlights = Spotlights::all();

        return view('admin.spotlightslist')->with('spotlights', $spotlights);
    }
}
