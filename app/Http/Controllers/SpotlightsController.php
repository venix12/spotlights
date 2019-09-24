<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spotlights;
use Auth;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;

class SpotlightsController extends Controller
{   
    public function index()
    {
        if(!Auth::check)
        {
            return redirect('/');
        }
        
        $spotlights = Spotlights::all();
        return view('spotlights.index')->with('spotlights', $spotlights);
    }

    public function show($id)
    {
        $spotlights = Spotlights::find($id);

        if(Auth::check() || !$spotlights)
        {
            return redirect('/');
        }

        $nominations = SpotlightsNomination::orderBy('score', 'DESC')->get();

        $votes = SpotlightsNominationVote::all();

        return view('spotlights.show')
            ->with('spotlights', $spotlights)
            ->with('nominations', $nominations)
            ->with('votes', $votes);

    }
    public function nominate(Request $request, $id)
    {
        $spotlights = Spotlights::find($id);
        
        //get api string
        $key = env('OSU_API_KEY');
        $url = 'osu.ppy.sh/api/get_beatmaps?k='.$key.'&s='.$request->beatmap_id;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $beatmapData = json_decode((string) $response->getBody(), true);

        //get beatmap data from api
        foreach($beatmapData as $key => $item)
        {
            $beatmapCreator = $item['creator'];
            $beatmapArtist = $item['artist'];
            $beatmapTitle = $item['title'];
        }

        //add nomination entry to database
        $nomination = new SpotlightsNomination();
        $nomination->spots_id = $id;
        $nomination->user_id = Auth::user()->id;
        $nomination->beatmap_id = $request->beatmap_id;
        $nomination->beatmap_artist = $beatmapArtist;
        $nomination->beatmap_title = $beatmapTitle;
        $nomination->beatmap_creator = $beatmapCreator;
        $nomination->score = 1;
        $nomination->save();
        
        return redirect()->back()->with('success', 'Nominated a beatmap successfully!')->with('beatmapData', $beatmapData);
    }

    public function new()
    {
        return view('admin.createspots');
    }

    public function create(Request $request)
    {
        
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
            $spotlights->$mode = 1;

            $spotlights->save();
        }

        if($modes == null)
        {
            $spotlights = new Spotlights();
            $spotlights->title = $request->title;
            $spotlights->description = $request->description;

            $spotlights->save();
        }

        return redirect()->back()->with('success', 'Created new spotlights!');
    }

    public function activate(Request $request)
    {
        $spotlights = Spotlights::find($request->spotlightsID);
        $spotlights->active = 1;
        $spotlights->save();
        return redirect()->back()->with('success', 'Successfully activated the spotlights!');
    }

    public function deactivate(Request $request)
    {
        $spotlights = Spotlights::find($request->spotlightsID);
        $spotlights->active = 0;
        $spotlights->save();
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

        return redirect()->back()->with('success', 'Successfully removed the spotlights!');
    }
}
