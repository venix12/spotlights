<?php

namespace App\Models;

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
     * Methods
     */

    public function score()
    {
        $key = "score_{$this->id}";

        if (!Cache::get($key)) {
            $votes = $this->votes->where('value', '!==', null);

            if ($this->spotlights->isLegacy()) {
                $score = 1;

                foreach ($votes as $vote) {
                    if ($vote->value !== 2) {
                        // 2 = contributor
                        $score += $vote->value;
                    }
                }
            } else {
                $scoreRaw = 0;

                foreach ($votes as $vote) {
                    $scoreRaw += $vote->value;
                }

                if ($votes->count() > 0) {
                    $score = $scoreRaw / $votes->count();
                } else {
                    $score = $scoreRaw;
                }
            }

            Cache::forever($key, $score);
        }

        return Cache::get($key);
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
