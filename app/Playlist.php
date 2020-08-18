<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        'osu_room_id',
        'osu_room_name',
        'participant_count',
        'season_id',
    ];
}
