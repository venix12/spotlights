<?php

/**
 * bool $active
 * bool $required
 * enum $type ['checkbox', 'input', 'multiple-choice', 'section', 'textarea']
 * int $char_limit
 * int $order
 * int $parent_id
 * int $relation_type
 * string $description
 * string $question
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppQuestion extends Model
{
    const RELATION_TYPES = [
        0 => 'alone',
        1 => 'parent',
        2 => 'child',
    ];

    protected $casts = [
        'active' => 'boolean',
        'required' => 'boolean',
    ];

    protected $fillable = [
        'active',
        'char_limit',
        'description',
        'order',
        'question',
        'parent_id',
        'relation_type',
        'required',
        'type',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function children() {
        return $this->hasMany(static::class, 'parent_id')->where('active', true);
    }

    public function parent() {
        return $this->belongsTo(static::class, 'parent_id');
    }
}
