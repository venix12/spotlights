<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistEntry extends Model
{
    protected $table = 'compose_playlist_entries';

    protected $fillable = [
        'artist',
        'creator',
        'creator_osu_id',
        'difficulty',
        'difficulty_name',
        'mod',
        'osu_beatmap_id',
        'playlist_id',
        'ranked_at',
        'title',
    ];

    public function metadataForDisplay()
    {
        return "{$this->artist} - {$this->title} ({$this->creator}) [{$this->difficulty_name}]";
    }
}
