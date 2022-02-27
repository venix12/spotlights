<?php

namespace App\Http\Controllers\Admin\Leaderboards;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard\Division;
use App\Models\Leaderboard\Season;
use App\Models\User;

class SeasonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create()
    {
        return view('admin.leaderboards.create-season');
    }

    public function index()
    {
        $seasons = Season::all();

        return view('admin.leaderboards.index')
            ->with('seasons', $seasons);
    }

    public function raw($id)
    {
        $season = Season::findOrFail($id);

        $divisions = $season->divisionsThresholds();

        $raw = '';

        $leaderboard = [];

        foreach ($season->uniquePlayers() as $player) {
            $user = User::find($player);

            $leaderboard[] = [
                'total_score' => $user->seasonTotalScore($season->id),
                'username' => $user->username,
                'osu_id' => $user->osu_user_id,
            ];
        }

        usort($leaderboard, function ($a, $b) {
            return $b['total_score'] - $a['total_score'];
        });

        for ($i = 0; $i < count($leaderboard); $i++) {
            $rank = $i + 1;

            $closestDivisionId = closest_range_value($rank, $divisions);
            $division = Division::find($closestDivisionId);

            $leaderboard[$i]['rank'] = $rank;
            $leaderboard[$i]['division']['identifier'] = $division->name;
            $leaderboard[$i]['division']['display'] = $division->display;
            $leaderboard[$i]['division']['title'] = $division->badgeTooltip();
        }

        foreach ($leaderboard as $item) {
            $raw .= "{$item['osu_id']}|{$item['division']['title']}\n";
        }

        return response($raw)->header('Content-Type', 'text/plain');
    }

    public function show($id)
    {
        $season = Season::findOrFail($id);

        return view('admin.leaderboards.show')
            ->with('season', $season);
    }

    public function supportersRaw($id)
    {
        $season = Season::find($id);
        $playlists = $season->playlists;
        $raw = '';

        foreach ($playlists as $playlist)
        {
            $topScores = $playlist->scores->sortByDesc('total_score')->take(10);

            foreach ($topScores as $score) {
                $user = $score->user;
                $raw .= "{$user->osu_user_id}|{$user->username}\n";
            }
        }

        return response($raw)->header('Content-Type', 'text/plain');
    }

    public function store()
    {
        Season::create([
            'name' => request()->name,
            'prefix' => request()->prefix,
        ]);

        return redirect(route('admin.seasons'));
    }
}
