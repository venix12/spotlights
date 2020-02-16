<?php

/**
 * bool $active
 * bool $required
 * int $char_limit
 * string $question
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppQuestion extends Model
{
    protected $casts = [
        'active' => 'boolean',
        'required' => 'boolean',
    ];

    protected $fillable = [
        'char_limit',
        'question',
        'required',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
