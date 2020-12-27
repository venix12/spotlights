<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Leaderboard\Playlist;
use App\Models\Leaderboard\Score;
use App\Models\User;
use App\Models\UserGroup;

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

            foreach ($scores['leaderboard'] as $score) {
                $osuUserId = $score['user']['id'];
                $user = User::where('osu_user_id', $osuUserId)->first();

                if ($user === null) {
                    $user = User::create([
                        'osu_user_id' => $osuUserId,
                        'username' => $score['user']['username'],
                    ]);

                    UserGroup::create([
                        'group_id' => Group::byIdentifier('default')->id,
                        'user_id' => $user->id,
                    ]);
                }

                $totalScore = $score['total_score'];

                $currentScore = Score::where('playlist_id', $playlist->id)
                    ->where('user_id', $user->id);

                if ($currentScore->exists()) {
                    $currentScore->update([
                        'total_score' => $totalScore,
                    ]);
                } else {
                    Score::create([
                        'playlist_id' => $playlist->id,
                        'total_score' => $totalScore,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        return redirect(route('admin.seasons.show', $id));
    }
}
