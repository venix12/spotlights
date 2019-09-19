<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Spotlights;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
use App\User;


class UserProfileController extends Controller
{   
    public function index($user_id)
    {
        $user = User::find($user_id);

        if(!Auth::check() || !$user)
        {
            return redirect('/');
        }

        if($user->active == 0 && !Auth::user()->isAdmin())
        {
            return redirect('/');
        }

        $votes = SpotlightsNominationVote::all();

        $nominations = SpotlightsNomination::all();

        return view('user.userprofile')
            ->with('user', $user)
            ->with('votes', $votes)
            ->with('nominations', $nominations);
    }
}
