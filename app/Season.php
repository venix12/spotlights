<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name',
    ];

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

    public function uniquePlayers()
    {
        return $this->scores->pluck('user_id')->unique();
    }

    public function divisions()
    {
        return $this->hasMany(Division::class, 'season_id');
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
