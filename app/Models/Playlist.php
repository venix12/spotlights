<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'compose_playlists';

    protected $fillable = [
        'name',
        'mode',
        'season_id',
    ];

    public function entriesSortedForListing()
    {
        return $this->entries;
    }

    public function entries()
    {
        return $this->hasMany(PlaylistEntry::class);
    }
}
