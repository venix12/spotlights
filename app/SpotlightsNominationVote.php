<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotlightsNominationVote extends Model
{
    protected $fillable = [
        'comment',
        'comment_updated_at',
        'nomination_id',
        'spots_id',
        'user_id',
        'value',
    ];

    const VOTE_VALUES = [
        'contribute' => 2,
        'criticize' => -1,
        'neutral' => 0,
        'support' => 1,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vote()
    {
        return $this->belongsTo(SpotlightsNomination::class, 'nomination_id');
    }
}
