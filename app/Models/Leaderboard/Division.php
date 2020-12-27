<?php

namespace App\Models\Leaderboard;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $casts = [
        'absolute' => 'boolean',
    ];

    protected $fillable = [
        'absolute',
        'display',
        'name',
        'season_id',
        'threshold',
    ];

    public function getNameAttribute($value)
    {
        return "{$this->season->prefix}-{$value}";
    }

    public function badgeTooltip()
    {
        return "Beatmap Spotlights: {$this->season->name} ({$this->display})";
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
