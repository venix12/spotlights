<?php

namespace App\Http\Controllers;

use Auth;
use App\Event;
use App\Spotlights;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
use App\User;
use Illuminate\Http\Request;

class SpotlightsController extends Controller
{   
    public function index()
    {
        if(!Auth::check())
        {
            return redirect('/');
        }

        $spotlights = Spotlights::all();
        return view('spotlights.index')->with('spotlights', $spotlights);
    }

    public function beatmaps(Request $request, $id)
    {
        $spotlights = Spotlights::find($id);

        $validator = $this->validate(request(),[
            'threshold' => 'int',
        ]);

        $orderNominations = SpotlightsNomination::orderBy('score', 'DESC')->get();
        $nominations = $orderNominations->where('spots_id', $id)->where('score', '>=', $request->threshold);
        
        return view('spotlights.mapids')
            ->with('nominations', $nominations)
            ->with('spotlights', $spotlights)
            ->with('threshold', $request->threshold);
    }

    public function show($id)
    {
        $spotlights = Spotlights::find($id);

        if(!Auth::check() || !$spotlights)
        {
            return redirect('/');
        }

        $orderNominations = SpotlightsNomination::orderBy('score', 'DESC')->get();
        $nominations = $orderNominations->where('spots_id', $id);

        $users = User::all();

        $votes = SpotlightsNominationVote::where('spots_id', $id)->get();

        return view('spotlights.show.main')
            ->with('nominations', $nominations)
            ->with('spotlights', $spotlights)
            ->with('users', $users)
            ->with('votes', $votes);
    }

    public function nominate(Request $request, $id)
    {
        $nominations = SpotlightsNomination::where('spots_id', $id)->get();
        
        if(count($nominations->where('beatmap_id', $request->beatmap_id)) > 0)
        {
            return redirect()->back()->with('error', 'This map has already been nominated!');
        }

        //get api string
        $key = env('OSU_API_KEY');
        $url = 'osu.ppy.sh/api/get_beatmaps?k='.$key.'&s='.$request->beatmap_id;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $beatmapData = json_decode((string) $response->getBody(), true);

        if($beatmapData == null)
        {
            return redirect()->back()->with('error', 'No beatmapset found, make sure you put numbers only!');
        }

        //get beatmap data from api
        foreach($beatmapData as $key => $item)
        {
            $beatmapArtist = $item['artist'];
            $beatmapCreator = $item['creator'];
            $beatmapCreatorId = $item['creator_id'];
            $beatmapTitle = $item['title'];
        }

        //add nomination entry to database
        $nomination = new SpotlightsNomination();
        $nomination->beatmap_artist = $beatmapArtist;
        $nomination->beatmap_creator = $beatmapCreator;
        $nomination->beatmap_creator_osu_id = $beatmapCreatorId;
        $nomination->beatmap_id = $request->beatmap_id;
        $nomination->beatmap_title = $beatmapTitle;
        $nomination->score = 1;
        $nomination->spots_id = $id;
        $nomination->user_id = Auth::user()->id;
        $nomination->save();
        
        return redirect()->back()->with('success', 'Nominated a beatmap successfully!')->with('beatmapData', $beatmapData);
    }

    public function new()
    {
        return view('admin.createspots');
    }

    public function create(Request $request)
    {
        $this->validate(request(),[

            'deadline' => 'required|date_format:Y-m-d',

        ]);

        $deadline = $request->deadline." 23:59:59";
        
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
            if ($mode == 'osu'){
                $titlePart = 'osu!';
            }

            if ($mode == 'taiko'){
                $titlePart = 'osu!taiko';
            }

            if($mode == 'catch'){
                $titlePart = 'osu!catch';
            }

            if($mode == 'mania'){
                $titlePart = 'osu!mania';
            }

            $title = $request->title." ($titlePart)";

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

        Event::log("Created new spotlights ".$request->title);

        return redirect()->back()->with('success', 'Created new spotlights!');
    }

    public function activate(Request $request)
    {
        $spotlights = Spotlights::find($request->spotlightsID);
        $spotlights->active = 1;
        $spotlights->save();

        Event::log("Activated spotlights ".$spotlights->title);

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

        Event::log("Removed spotlights ".$spotlights->title);

        return redirect()->back()->with('success', 'Successfully removed the spotlights!');
    }

    public function release(Request $request)
    {
        $spotlights = Spotlights::find($request->spotlightsID);

        $spotlights->released = 1;
        $spotlights->released_at = now();
        $spotlights->save();

        Event::log("Released spotlights ".$spotlights->title);

        return redirect()->back()->with('success', 'Successfully released the spotlights!');
    }
}
