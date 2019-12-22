<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotlightsNomination extends Model
{
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

    public function spotlights()
    {
        return $this->belongsTo('Spotlights');
    }

    public function votes()
    {
        return $this->hasMany('SpotlightsNominationVote');
    }
}
