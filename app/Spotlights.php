<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spotlights extends Model
{
    protected $attributes = [
        'osu' => 0,
        'taiko' => 0,
        'catch' => 0,
        'mania' => 0,
    ];

    public function nominations()
    {
        return $this->hasMany('SpotlightNomination');
    }
}
