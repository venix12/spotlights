<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpotlightsNominationVote;
use App\SpotlightsNomination;
use Auth;

class SpotlightsNominationVoteController extends Controller
{
    public function index(Request $request)
    {

        $this->validate(request(),[
            
            'optionsRadios' => 'required|in:voteFor,voteNeutral,voteAgainst,voteContributed',

        ]);

        if ($request->optionsRadios == 'voteFor')
        {
            $voteValue = 1;
        }

        if ($request->optionsRadios == 'voteNeutral')
        {
            $voteValue = 0;
        }

        if($request->optionsRadios == 'voteAgainst')
        {
            $voteValue = -1;
        }

        if($request->optionsRadios == 'voteContributed')
        {
            $voteValue = 2;
        }
        
        //check if user voted already

        //create vote
        $vote = new SpotlightsNominationVote();
        $vote->value = $voteValue;
        $vote->user_id = Auth::user()->id;
        $vote->spots_id = $request->spotlightsID;
        $vote->nomination_id = $request->nominationID;
        if (strlen($request->commentField) > 0)
        {
            $vote->comment = $request->commentField;
        }
        $vote->save();

        //change score of nomination
        if($voteValue < 2)
        {
            $nomination = SpotlightsNomination::find($request->nominationID);
            $nomination->score += $voteValue;
            $nomination->save();
        }

        return redirect()->back()->with('success', 'Vote casted successfully!');
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            
            'optionsRadios' => 'required|in:voteFor,voteNeutral,voteAgainst,voteContributed',

        ]);

        $vote = SpotlightsNominationVote::find($request->voteID);

        if ($request->optionsRadios == 'voteFor')
        {
            if($vote->value == -1)
            {
                $scoreAdd = 2;
            } else {
                $scoreAdd = 1;
            }
            
            $voteValue = 1;
        }

        if ($request->optionsRadios == 'voteNeutral')
        {
            if($vote->value == -1)
            {
                $scoreAdd = 1;
            } 
            elseif($vote->value == 1) 
            {
                $scoreAdd = -1;
            }
            else
            {
                $scoreAdd = 0;
            }

            $voteValue = 0;

        }

        if($request->optionsRadios == 'voteAgainst')
        {
            if($vote->value == 1)
            {
                $scoreAdd = -2;
            } else {
                $scoreAdd = -1;
            }

            $voteValue = -1;
        }

        if($request->optionsRadios == 'voteContributed')
        {
            if($vote->value == -1)
            {
                $scoreAdd = 1;
            } 
            elseif($vote->value == 1)
            {
                $scoreAdd = -1;
            }
            else
            {
                $scoreAdd = 0;
            }

            $voteValue = 2;
        }
        

        //change score of nomination
        if($vote->value != $voteValue)
        {
            $nomination = SpotlightsNomination::find($request->nominationID);
            $nomination->score += $scoreAdd;
            $nomination->save();
        } 

        $vote->value = $voteValue;
        $vote->user_id = Auth::user()->id;
        $vote->spots_id = $request->spotlightsID;
        $vote->nomination_id = $request->nominationID;
        if (strlen($request->commentField) > 0)
        {
            $vote->comment = $request->commentField;
        }
        $vote->save();

        return redirect()->back()->with('success', 'Vote updated successfully!');

    }

    public function remove_comment(Request $request)
    {

        $vote = SpotlightsNominationVote::find($request->voteID);

        $vote->comment = null;

        $vote->save();

        return redirect()->back()->with('success', 'Removed a comment successfully!');
    }
}
