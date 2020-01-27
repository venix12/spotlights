<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spotlights extends Model
{
    const GAME_MODES = ['catch', 'mania', 'osu', 'taiko'];


    protected $casts = [
        'active' => 'boolean',
        'catch' => 'boolean',
        'mania' => 'boolean',
        'osu' => 'boolean',
        'released' => 'boolean',
        'taiko' => 'boolean'
    ];

    public function deadlineInDays()
    {
        $days = $this->deadlineLate()
            ? '-' . now()->diffInDays($this->deadline)
            : now()->diffInDays($this->deadline);

        return $days;
    }

    public function deadlineLate()
    {
        return $this->deadline < now();
    }

    public function gamemode()
    {
        foreach (self::GAME_MODES as $gamemode) {
            if ($this->$gamemode === true) {
                $mode = $gamemode;
            }
        }

        return $mode;
    }

    public function nominations()
    {
        return $this->hasMany('SpotlightNomination');
    }
}
