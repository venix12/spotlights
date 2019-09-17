<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Spotlights;
use Illuminate\Http\Request;

class SpotlightsListController extends Controller
{
    public function index()
    {
    if(!Auth::check() || !Auth::user()->isAdmin())
        {
            return redirect('/');
        }

    $spotlights = Spotlights::all();

    return view('admin.spotlightslist')->with('spotlights', $spotlights);
    }
}
