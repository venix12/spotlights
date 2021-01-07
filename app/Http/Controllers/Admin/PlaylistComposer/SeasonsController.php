<?php

namespace App\Http\Controllers\Admin\PlaylistComposer;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\User;

class SeasonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->only(['store', 'wikiExport']);
        $this->middleware('is_team_leader');
    }

    public function index()
    {
        $seasons = Season::all();

        return view('admin.playlist-composer.index')
            ->with('seasons', $seasons);
    }

    public function show($id)
    {
        $season = Season::findOrFail($id)
            ->with('playlists')
            ->with('playlists.entries')
            ->first();

        $validationErrors = $season->validate();

        return view('admin.playlist-composer.show')
            ->with('season', $season)
            ->with('validationErrors', $validationErrors);
    }

    public function store()
    {
        Season::create([
            'name' => request()->name,
        ]);

        return redirect()->back();
    }

    public function wikiExport($id)
    {
        $season = Season::findOrFail($id);
        $playlists = explode(' ', request()->playlists);

        $output = '';

        foreach (User::MODES as $mode) {
            $modeFormatted = gamemode($mode);
            $output .= "### {$modeFormatted}\n\n";

            foreach ($playlists as $playlistIndicator) {
                $playlistName = "Playlist {$playlistIndicator}";

                $playlist = $season->playlists
                    ->where('mode', $mode)
                    ->where('name', $playlistName)
                    ->first();

                $entries = $playlist->entries ?? [];

                $output .= "#### {$playlistName}\n\n";

                foreach ($entries as $entry) {
                    $escapedMetadata = addcslashes($entry->metadataForDisplay(), '[]_*');
                    $mod = $entry->mod ? " +{$entry->mod}" : null;

                    $output .= "- [{$escapedMetadata}](https://osu.ppy.sh/beatmaps/{$entry->osu_beatmap_id}){$mod}\n";
                }

                $output .= "\n";
            }
        }

        return response($output)->header('Content-Type', 'text/plain');
    }
}
