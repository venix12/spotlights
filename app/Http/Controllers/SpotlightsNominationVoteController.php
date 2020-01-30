<?php

namespace App\Http\Controllers;

use App\SpotlightsNominationVote;
use Auth;
use Cache;
use Illuminate\Http\Request;

class SpotlightsNominationVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin')->only('remove_comment');
    }

    public function update(Request $request)
    {
        $vote = SpotlightsNominationVote::find($request->vote_id);

        $vote->value = $request->vote_value;

        if ($vote->comment !== $request->comment)
        {
            $vote->comment = $request->comment;
            $vote->comment_updated_at = now();
        }

        $vote->save();

        Cache::forget("score_{$request->nomination_id}");

        return redirect()->back()
            ->with('success', 'Vote updated successfully!');

    }

    public function removeComment(Request $request)
    {
        $vote = SpotlightsNominationVote::find($request->voteID);

        if ($vote->value === null) {
            $vote->delete();
        } else {
            $vote->comment = null;
            $vote->save();
        }

        return redirect()->back()
            ->with('success', 'Removed a comment successfully!');
    }

    public function store(Request $request)
    {
        SpotlightsNominationVote::create([
            'comment' => $request->comment,
            'nomination_id' => $request->nomination_id,
            'user_id' => Auth::user()->id,
            'spots_id' => $request->spotlights_id,
            'value' => $request->vote_value,
        ]);

        Cache::forget("score_{$request->nomination_id}");

        return redirect()->back()
            ->with('success', 'Vote casted successfully!');
    }
}
