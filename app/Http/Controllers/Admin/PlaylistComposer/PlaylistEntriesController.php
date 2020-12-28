<?php

namespace App\Http\Controllers\Admin\PlaylistComposer;

use App\Http\Controllers\Controller;
use App\Models\PlaylistEntry;
use OsuApi;

class PlaylistEntriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_team_leader');
    }

    public function remove($id)
    {
        $entry = PlaylistEntry::find($id);
        $entry->delete();

        return redirect()->back()
            ->with('success', 'Successfully removed an entry!');
    }

    public function store()
    {
        $response = OsuApi::getBeatmap(request()->beatmapset_id);

        if ($response === []) {
            return redirect()->back()
                ->with('error', 'Beatmap not found!');
        }

        $beatmapData = $response[0];

        PlaylistEntry::create([
            'artist' => $beatmapData['artist'],
            'creator' => $beatmapData['creator'],
            'creator_osu_id' => $beatmapData['creator_id'],
            'difficulty' => request()->difficulty,
            'difficulty_name' => $beatmapData['version'],
            'mod' => request()->mod,
            'osu_beatmap_id' => $beatmapData['beatmap_id'],
            'playlist_id' => request()->playlist_id,
            'ranked_at' => $beatmapData['approved_date'],
            'title' => $beatmapData['title'],
        ]);

        return redirect()->back();
    }
}
