<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;

class SpotlightsNominationController extends Controller
{
    public function destroy(Request $request)
    {
        //remove votes
        $vote = SpotlightsNominationVote::where('nomination_id', $request->nominationID);
        $vote->delete();

        $nomination = SpotlightsNomination::find($request->nominationID);
        $nomination->delete();
        
        return redirect()->back()->with('success', 'Removed nomination successfully!');
    }

}
