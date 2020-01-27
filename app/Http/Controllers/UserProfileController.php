<?php

namespace App\Http\Controllers;

use App\Spotlights;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
use App\User;
use Illuminate\Http\Request;
use Auth;


class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $user = User::find($id);

        if(!$user)
        {
            return redirect('/');
        }

        if (!$user->active && !Auth::user()->isAdminOrManager())
        {
            return redirect('/');
        }

        $nominations = SpotlightsNomination::all();

        $spotlights = Spotlights::all();
        $userSpotlights = $nominations->where('user_id', $id);

        $votes = SpotlightsNominationVote::all();
        $userVotes = $votes->where('user_id', $id);

        $spotlightsParticipated = [];

        foreach($userSpotlights as $userSpotlight)
        {
            if(!in_array($spotlights->find($userSpotlight->spots_id)->title, $spotlightsParticipated))
            {
                $spotlightsParticipated[] = $spotlights->find($userSpotlight->spots_id)->title;
            }
        }

        foreach($userVotes as $userVote)
        {
            if(!in_array($spotlights->find($userVote->spots_id)->title, $spotlightsParticipated))
            {
                $spotlightsParticipated[] = $spotlights->find($userVote->spots_id)->title;
            }
        }

        return view('user.userprofile')
            ->with('nominations', $nominations)
            ->with('user', $user)
            ->with('spotlightsParticipated', $spotlightsParticipated)
            ->with('votes', $votes);
    }
}
