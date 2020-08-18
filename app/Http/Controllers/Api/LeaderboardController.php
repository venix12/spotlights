<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Season;
use App\User;

class LeaderboardController extends Controller
{
    public function show($id)
    {
        $season = Season::find($id);
        $divisions = $season->divisionsThresholds();

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

            $leaderboard[$i]['rank'] = $rank;
            $leaderboard[$i]['division'] = closest_range_value($rank, $divisions);
        }

        return $leaderboard;
    }
}
