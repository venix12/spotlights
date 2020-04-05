<?php

/**
 * bool $active
 * bool $required
 * enum $type ['checkbox', 'input', 'multiple-choice', 'section', 'textarea']
 * int $char_limit
 * int $order
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
        'active',
        'char_limit',
        'order',
        'question',
        'required',
        'type',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
