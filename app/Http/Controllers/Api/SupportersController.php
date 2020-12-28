<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard\Season;

class SupportersController extends Controller
{
    public function show($id)
    {
        $season = Season::find($id);
        $playlists = $season->playlists;

        $userInfo = [];

        foreach ($playlists as $playlist)
        {
            $topScores = $playlist->scores->sortBy('total_score')->take(10);

            foreach ($topScores as $score) {
                $user = $score->user;

                $userInfo[$playlist->osu_room_id][] = [
                    'osu_id' => $user->osu_user_id,
                    'username' => $user->username,
                ];
            }
        }

        return $userInfo;
    }
}
