<?php

namespace App\Models\Leaderboard;

use Illuminate\Database\Eloquent\Model;

class LeaderboardFactor extends Model
{
    protected $fillable = [
        'factor',
        'season_id',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
