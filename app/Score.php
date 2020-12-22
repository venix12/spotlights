<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'playlist_id',
        'total_score',
        'user_id',
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class, 'playlist_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
