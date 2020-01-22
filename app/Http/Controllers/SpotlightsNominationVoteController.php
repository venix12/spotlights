<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpotlightsNominationVote;
use App\SpotlightsNomination;
use Auth;

class SpotlightsNominationVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin')->only('remove_comment');
    }

    public function index(Request $request)
    {
        switch ($request->optionsRadios)
        {
            case 'voteFor':
                $voteValue = 1;
                break;

            case 'voteNeutral':
                $voteValue = 0;
                break;

            case 'voteAgainst':
                $voteValue = -1;
                break;

            case 'voteContributed':
                $voteValue = 2;
                break;

            default:
                $voteValue = null;
                break;
        }

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

        // 2 is contribution so it doesn't affect the score
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

        $vote = SpotlightsNominationVote::find($request->voteID);

        if (!$request->optionRadios)
        {
            $voteValue = null;
        }

        if ($request->optionsRadios == 'voteFor')
        {
            if($vote->value == -1) {
                $scoreAdd = 2;
            } else {
                $scoreAdd = 1;
            }

            $voteValue = 1;
        }

        if ($request->optionsRadios == 'voteNeutral')
        {
            if ($vote->value == -1)
            {
                $scoreAdd = 1;
            }

            else if ($vote->value == 1)
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

        if ($vote->comment != $request->commentField)
        {
            $vote->comment = $request->commentField;
            $vote->comment_updated_at = now();
        }

        $vote->save();

        return redirect()->back()->with('success', 'Vote updated successfully!');

    }

    public function remove_comment(Request $request)
    {

        $vote = SpotlightsNominationVote::find($request->voteID);

        if($vote->value === null) {
            $vote->delete();
        } else {
            $vote->comment = null;

            $vote->save();
        }

        return redirect()->back()->with('success', 'Removed a comment successfully!');
    }
}
