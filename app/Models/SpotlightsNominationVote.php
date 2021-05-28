<?php

namespace App\Models;

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

    const ALLOWED_VOTE_VALUES = [1, 2, 3, 4, 5];

    public static function parseVoteValue($value)
    {
        return in_array($value, static::ALLOWED_VOTE_VALUES)
            ? $value
            : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nomination()
    {
        return $this->belongsTo(SpotlightsNomination::class, 'nomination_id');
    }
}
