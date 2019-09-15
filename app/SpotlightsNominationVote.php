<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotlightsNominationVote extends Model
{
    public function vote()
    {
        return $this->belongsTo('SpotlightsNomination');
    }
}
