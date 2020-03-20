<?php

namespace App\Http\Controllers;

use App\Spotlights;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
use App\User;
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

        if (!$user) {
            return redirect('/');
        }

        if (!$user->isMember() && !Auth::user()->isAdminOrManager()) {
            return redirect('/');
        }

        $nominations = SpotlightsNomination::all();
        $spotlights = Spotlights::all();
        $votes = SpotlightsNominationVote::all();

        $userNominations = $nominations->where('user_id', $id);
        $userVotes = $votes->where('user_id', $id);

        $spotlightsParticipated = [];

        foreach($userNominations as $userSpotlight)
        {
            if(!in_array($spotlights->find($userSpotlight->spots_id), $spotlightsParticipated))
            {
                $spotlightsParticipated[] = $spotlights->find($userSpotlight->spots_id);
            }
        }

        foreach($userVotes as $userVote)
        {
            if(!in_array($spotlights->find($userVote->spots_id), $spotlightsParticipated))
            {
                $spotlightsParticipated[] = $spotlights->find($userVote->spots_id);
            }
        }

        return view('user.userprofile')
            ->with('nominations', $nominations)
            ->with('user', $user)
            ->with('spotlightsParticipated', $spotlightsParticipated)
            ->with('votes', $votes);
    }
}
