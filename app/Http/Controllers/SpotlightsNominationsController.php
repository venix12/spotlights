<?php

namespace App\Http\Controllers;

use App\Spotlights;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
use Illuminate\Http\Request;

class SpotlightsNominationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_member');
        $this->middleware('is_admin')->only('destroy');
    }

    public function destroy(Request $request)
    {
        // remove nomination votes so there's no database conflict
        $vote = SpotlightsNominationVote::where('nomination_id', $request->nominationID);
        $vote->delete();

        $nomination = SpotlightsNomination::find($request->nominationID);
        $nomination->delete();

        return redirect()->back()->with('success', 'Removed nomination successfully!');
    }

    public function store($id)
    {
        $beatmapId = request()->id;
        $currentNominations = SpotlightsNomination::where('beatmap_id', $beatmapId)->get();

        // TODO: move to frontend?
        if (count($currentNominations) > 0) {
            return json_error('this map has already been nominated!');
        }

        $beatmapData = SpotlightsNomination::createEntry($beatmapId, $id);

        if ($beatmapData['error']) {
            return json_error($beatmapData['error']);
        }

        if (request()->comment !== null) {
            SpotlightsNominationVote::create([
                'comment' => request()->comment,
                'nomination_id' => $beatmapData->id,
                'user_id' => auth()->user()->id,
                'spots_id' => $id,
            ]);
        }

        return fractal_item($beatmapData, 'NominationTransformer');
    }
}
