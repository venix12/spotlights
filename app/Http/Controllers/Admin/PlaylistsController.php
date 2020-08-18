<?php

namespace App\Http\Controllers\Admin;

use App\Playlist;
use App\Score;
use App\Http\Controllers\Controller;
use App\User;

class PlaylistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create($id)
    {
        return view('admin.leaderboards.create-playlist')
            ->with('id', $id);
    }

    public function store($id)
    {
        $roomId = request()->room_id;
        $roomInfo = app('osu-oauth')->getRoomInfo($roomId);

        $playlist = Playlist::create([
            'osu_room_id' => $roomId,
            'osu_room_name' => $roomInfo['name'],
            'participant_count' => $roomInfo['participant_count'],
            'season_id' => $id,
        ]);

        $pagesCount = ceil($roomInfo['participant_count'] / 50);

        for ($i = 1; $i <= $pagesCount; $i++) {
            $scores = app('osu-oauth')->getRoomLeaderboard($roomId, $i);

            foreach ($scores as $score) {
                $osuUserId = $score['user']['id'];
                $user = User::where('osu_user_id', $osuUserId)->first();

                if ($user === null) {
                    $user = User::create([
                        'osu_user_id' => $osuUserId,
                        'username' => $score['user']['username'],
                    ]);
                }

                $totalScore = $score['total_score'];

                $currentScore = Score::where('playlist_id', $playlist->id)
                    ->where('user_id', $user->id);

                if (!$currentScore->exists()) {
                    Score::create([
                        'playlist_id' => $playlist->id,
                        'total_score' => $totalScore,
                        'user_id' => $user->id,
                    ]);
                } else {
                    $currentScore->update([
                        'total_score' => $totalScore,
                    ]);
                }
            }
        }

        return redirect(route('admin.seasons.show', $id));
    }
}
