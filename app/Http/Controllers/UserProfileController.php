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
    public function index($id)
    {
        $user = User::find($id);

        if(!Auth::check() || !$user)
        {
            return redirect('/');
        }

        if($user->active == 0 && !(Auth::user()->isAdmin() || Auth::user()->isManager()))
        {
            return redirect('/');
        }
        
        $nominations = SpotlightsNomination::all();
        
        $spotlights = Spotlights::all();

        $userSpotlights = $nominations->where('user_id', $id);

        $votes = SpotlightsNominationVote::all();

        $spotlightsParticipated = [];

        foreach($userSpotlights as $userSpotlight)
        {
            if(!in_array($spotlights->find($userSpotlight->spots_id)->title, $spotlightsParticipated))
            {
                $spotlightsParticipated[] = $spotlights->find($userSpotlight->spots_id)->title;
            }
        }

        return view('user.userprofile')
            ->with('nominations', $nominations)
            ->with('user', $user)
            ->with('spotlightsParticipated', $spotlightsParticipated)
            ->with('votes', $votes);
    }
}
