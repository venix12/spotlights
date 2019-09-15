<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotlightsNomination extends Model
{
    public function spotlights()
    {
        return $this->belongsTo('Spotlights');
    }

    public function votes()
    {
        return $this->hasMany('SpotlightsNominationVote');
    }
}
