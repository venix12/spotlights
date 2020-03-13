<?php

namespace App\Http\Controllers;

use App\Event;
use App\Spotlights;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
use App\User;
use Illuminate\Http\Request;

class SpotlightsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_member');

        $this->middleware('is_admin')->only([
            'activate', 'create', 'deactivate', 'destroy', 'new',  'release', 'setThreshold'
        ]);
    }

    public function index()
    {
        $spotlights = Spotlights::all();

        return view('spotlights.index')->with('spotlights', $spotlights);
    }

    public function beatmaps(Request $request, $id)
    {
        $spotlights = Spotlights::find($id);

        $this->validate($request, [
            'threshold' => 'int',
        ]);

        $orderNominations = SpotlightsNomination::sortByScore();
        $nominations = $orderNominations->where('spots_id', $id)->where('score', '>=', $request->threshold);

        return view('spotlights.mapids')
            ->with('nominations', $nominations)
            ->with('spotlights', $spotlights)
            ->with('threshold', $request->threshold);
    }

    public function setThreshold(Request $request) {
        $spotlights = Spotlights::find($request->SpotlightsId);

        $spotlights->threshold = $request->threshold;
        $spotlights->save();

        return redirect()->back()->with('success', 'Successfully set the threshold!');
    }

    public function show($id)
    {
        $spotlights = Spotlights::with('nominations')
            ->with('nominations.user')
            ->with('nominations.votes')
            ->with('nominations.votes.user')
            ->find($id);

        if (!$spotlights) {
            return redirect('/');
        }

        $spotlightsCollection = fractal_transform($spotlights, 'SpotlightsTransformer', null, true);

        return view('spotlights.show.main')
            ->with('spotlights', $spotlights)
            ->with('spotlightsCollection', $spotlightsCollection);
    }

    public function new()
    {
        return view('admin.createspots');
    }

    public function create(Request $request)
    {
        $this->validate($request, [

            'deadline' => 'required|date_format:Y-m-d',

        ]);

        $deadline = "{$request->deadline} 23:59:59";

        $modes = [];

        if($request->osu == true){
            $modes[] = 'osu';
        }

        if($request->taiko == true){
            $modes[] = 'taiko';
        }

        if($request->catch == true){
            $modes[] = 'catch';
        }

        if($request->mania == true){
            $modes[] = 'mania';
        }

        foreach($modes as $mode)
        {
            switch ($mode) {
                case 'osu':
                    $modeIndicator = 'osu!';
                    break;

                case 'taiko':
                    $modeIndicator = 'osu!taiko';
                    break;

                case 'catch':
                    $modeIndicator = 'osu!catch';
                    break;

                case 'mania':
                    $modeIndicator = 'mania';
                    break;
            }

            $title = "$request->title ({$modeIndicator})";

            $spotlights = new Spotlights();
            $spotlights->title = $title;
            $spotlights->description = $request->description;
            $spotlights->deadline = $deadline;
            $spotlights->$mode = 1;

            $spotlights->save();
        }

        if($modes == null)
        {
            $spotlights = new Spotlights();
            $spotlights->title = $request->title;
            $spotlights->deadline = $deadline;
            $spotlights->description = $request->description;

            $spotlights->save();
        }

        Event::log("Created new spotlights {$request->title}");

        return redirect()->back()->with('success', 'Created new spotlights!');
    }

    public function activate(Request $request)
    {
        $spotlights = Spotlights::find($request->spotlightsID);
        $spotlights->active = 1;
        $spotlights->save();

        Event::log("Activated spotlights {$spotlights->title}");

        return redirect()->back()->with('success', 'Successfully activated the spotlights!');
    }

    public function deactivate(Request $request)
    {
        $spotlights = Spotlights::find($request->spotlightsID);
        $spotlights->active = 0;
        $spotlights->save();

        Event::log("Dectivated spotlights ".$spotlights->title);

        return redirect()->back()->with('success', 'Successfully deactivated the spotlights!');
    }

    public function destroy(Request $request)
    {
        $vote = SpotlightsNominationVote::where('spots_id', $request->spotlightsID);
        $nomination = SpotlightsNomination::where('spots_id', $request->spotlightsID);
        $spotlights = Spotlights::find($request->spotlightsID);

        $vote->delete();
        $nomination->delete();
        $spotlights->delete();

        Event::log("Removed spotlights {$spotlights->title}");

        return redirect()->back()->with('success', 'Successfully removed the spotlights!');
    }

    public function release(Request $request)
    {
        $spotlights = Spotlights::find($request->spotlightsID);

        $spotlights->released = 1;
        $spotlights->released_at = now();
        $spotlights->save();

        Event::log("Released spotlights {$spotlights->title}");

        return redirect()->back()->with('success', 'Successfully released the spotlights!');
    }
}
