<?php

namespace App\Http\Controllers;

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

        if(!$user)
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
