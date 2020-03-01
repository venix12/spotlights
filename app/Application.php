<?php

/**
 * bool $approved
 * enum $gamemode ['osu', 'taiko', 'mania', 'catch']
 * enum $verdict? ['fail', 'pass']
 * int $cycle_id
 * int $user_id
 * int $feedback_author_id
 * string $feedback
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $casts = [
        'approved' => 'boolean',
    ];

    protected $fillable = [
        'approved',
        'cycle_id',
        'feedback',
        'feedback_author_id',
        'gamemode',
        'user_id',
        'verdict',
    ];

    public function answers()
    {
        return $this->hasMany(AppAnswer::class, 'app_id');
    }

    public function cycle()
    {
        return $this->belongsTo(AppCycle::class, 'cycle_id');
    }

    public function feedbackAuthor()
    {
        return $this->belongsTo(User::class, 'feedback_author_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
