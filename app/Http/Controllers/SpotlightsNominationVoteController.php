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
        $this->middleware('is_member');
        $this->middleware('is_admin')->only('removeComment');
    }

    public function update()
    {
        $vote = SpotlightsNominationVote::where('nomination_id', request()->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($vote->comment !== request()->comment) {
            $vote->update([
                'comment' => request()->comment,
                'comment_updated_at' => now(),
            ]);
        }

        $value = SpotlightsNominationVote::VOTE_VALUES[request()->vote] ?? null;

        if ($vote->value !== $value) {
            $vote->update([
                'value' => $value,
            ]);
        }

        Cache::forget('score_' . request()->id);

        return fractal_item($vote, 'VoteTransformer');
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

    public function store($id)
    {
        $nomination_id = request()->id;

        $vote = SpotlightsNominationVote::create([
            'comment' => request()->comment,
            'nomination_id' => $nomination_id,
            'spots_id' => $id,
            'user_id' => auth()->id(),
            'value' => request()->vote ? SpotlightsNominationVote::VOTE_VALUES[request()->vote] : null,
        ]);

        Cache::forget("score_{$nomination_id}");

        return fractal_item($vote, 'VoteTransformer');
    }
}
