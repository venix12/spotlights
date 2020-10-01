<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name',
    ];

    public function divisionsForListing()
    {
        $listing = [];
        $i = 0;

        foreach ($this->divisions as $division) {
            $listing[$i]['id'] = $division->id;
            $listing[$i]['name'] = $division->name;

            if ($division->absolute === true) {
                $listing[$i]['threshold'] = $division->threshold;
            } else {
                $listing[$i]['threshold'] = $division->threshold * $this->participantCount();
            }

            $i += 1;
        }

        usort($listing, function ($a, $b) {
            return $a['threshold'] - $b['threshold'];
        });

        return $listing;
    }

    public function divisionsThresholds()
    {
        $thresholds = [];

        foreach ($this->divisions as $division) {
            if ($division->absolute === true) {
                $thresholds[$division->name] = $division->threshold;
            } else {
                $thresholds[$division->name] = $division->threshold * $this->participantCount();
            }
        }

        asort($thresholds);

        return $thresholds;
    }

    public function participantCount()
    {
        return $this->uniquePlayers()->count();
    }

    public function rawFactorsSorted()
    {
        return $this->factors->sortByDesc('factor')->pluck('factor');
    }

    public function uniquePlayers()
    {
        return $this->scores->pluck('user_id')->unique();
    }

    public function uniquePlaylistsCount()
    {
        return $this->playlists->unique('osu_room_name')->count();
    }

    public function divisions()
    {
        return $this->hasMany(Division::class, 'season_id');
    }

    public function factors()
    {
        return $this->hasMany(LeaderboardFactor::class, 'season_id');
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class, 'season_id');
    }

    public function scores()
    {
        return $this->hasManyThrough(Score::class, Playlist::class);
    }
}
