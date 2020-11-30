<?php

namespace App;

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

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
