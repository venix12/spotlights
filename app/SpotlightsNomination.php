<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use OsuApi;

class SpotlightsNomination extends Model
{
    protected $fillable = [
        'beatmap_artist',
        'beatmap_creator',
        'beatmap_creator_osu_id',
        'beatmap_id',
        'beatmap_title',
        'score',
        'spots_id',
        'user_id',
    ];

    public function getScoreColor()
    {
        $score = $this->score;

        if ($score < -4)
        {
            $scoreColor = "#ff0000"; //red
        }

        else if ($score < 0 && $score > -5)
        {
            $scoreColor = "#ff7373"; //lightred
        }

        else if ($score > 2 && $score < 5)
        {
            $scoreColor = "#577557"; //lightgreen
        }

        else if ($score > 4)
        {
            $scoreColor = "#12b012"; //green
        }

        else
        {
            $scoreColor = "#757575"; //gray
        }

        return $scoreColor;
    }

    public static function createEntry(int $beatmap_id, int $spotlights_id)
    {
        $response = OsuApi::getBeatmapset($beatmap_id);

        if ($response === [])
        {
            return ['error' => 'No beatmapset found, make sure you put numbers only!'];
        }

        $beatmapData = $response[0];

        if ($beatmapData['creator_id'] === Auth::user()->osu_user_id)
        {
            return ['error', 'You can\'t nominate your own maps!'];
        }

        $entry = self::create([
            'beatmap_artist' => $beatmapData['artist'],
            'beatmap_creator' => $beatmapData['creator'],
            'beatmap_creator_osu_id' => $beatmapData['creator_id'],
            'beatmap_id' => $beatmapData['beatmapset_id'],
            'beatmap_title' => $beatmapData['title'],
            'score' => 1,
            'spots_id' => $spotlights_id,
            'user_id' => Auth::user()->id,
        ]);

        return $entry;
    }

    public function spotlights()
    {
        return $this->belongsTo('Spotlights');
    }

    public function votes()
    {
        return $this->hasMany('SpotlightsNominationVote');
    }
}
