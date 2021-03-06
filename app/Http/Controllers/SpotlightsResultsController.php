<?php

namespace App\Http\Controllers;

use App\Models\Spotlights;
use App\Models\SpotlightsNomination;
use App\Models\SpotlightsNominationVote;
use App\Models\User;

class SpotlightsResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $spotlights = Spotlights::where('released', true)
            ->orderBy('id', 'DESC')
            ->get();

        return view('spotlights-results.index')
            ->with('spotlights', $spotlights);
    }

    public function show($id)
    {
        $spotlights = Spotlights::find($id);

        if(!$spotlights || $spotlights->released === false)
        {
            return redirect('/');
        }

        $orderNominations = SpotlightsNomination::sortByScore();
        $nominations = $orderNominations->where('spots_id', $id);

        $users = User::orderBy('username')->get();

        $votes = SpotlightsNominationVote::where('spots_id', $id)->get();

        return view('spotlights-results.show')
            ->with('nominations', $nominations)
            ->with('spotlights', $spotlights)
            ->with('users', $users)
            ->with('votes', $votes);
    }
}
