<?php

namespace App;

use App\SpotlightsNominationVote;
use Auth;
use Cache;
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

    /**
     * Attributes
     */

    public function getScoreAttribute()
    {
        $key = "score_{$this->id}";

        if (!Cache::get($key))
        {
            $votes = $this->votes;

            $score = 1;

            foreach ($votes as $vote) {
                // 2 = contributor
                if ($vote->value !== 2) {
                    $score += $vote->value;
                }
            }

            Cache::forever($key, $score);
        }

        return Cache::get($key);
    }

    /**
     * Methods
     */

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
            'spots_id' => $spotlights_id,
            'user_id' => Auth::user()->id,
        ]);

        return $entry;
    }

    public function metadata()
    {
        return "{$this->beatmap_artist} - {$this->beatmap_title}";
    }

    /**
     * Checks
     */

    public function isSpotlighted()
    {
        return $this->score >= $this->spotlights->threshold;
    }

    /**
     * Scopes
     */

    public function scopeSortByScore($query)
    {
        return $query->get()->sortByDesc('score');
    }

    /**
     * Relationships
     */

    public function spotlights()
    {
        return $this->belongsTo(Spotlights::class, 'spots_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function votes()
    {
        return $this->hasMany(SpotlightsNominationVote::class, 'nomination_id');
    }
}
