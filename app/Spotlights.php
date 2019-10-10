<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spotlights extends Model
{
    public function nominations()
    {
        return $this->hasMany('SpotlightNomination');
    }
}
