<?php

namespace App\Http\Controllers;

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

    public function store(Request $request, $id)
    {
        $nominations = SpotlightsNomination::where('spots_id', $id)->get();

        if (count($nominations->where('beatmap_id', $request->beatmap_id)) > 0)
        {
            return redirect()->back()->with('error', 'This map has already been nominated!');
        }

        $beatmapData = SpotlightsNomination::createEntry($request->beatmap_id, $id);

        if ($beatmapData['error'])
        {
            return redirect()->back()->with('error', $beatmapData['error']);
        }

        return redirect()->back()
            ->with('success', 'Nominated a beatmap successfully!')
            ->with('beatmapData', $beatmapData);
    }

}
