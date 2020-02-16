<?php

/**
 * bool $active
 * date $deadline
 * int $user_id
 * string $name
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppCycle extends Model
{
    protected $casts = [
        'active' => 'boolean',
    ];

    protected $fillable = [
        'deadline',
        'name',
        'user_id',
    ];

    /**
     * Scopes
     */

    public function scopeCurrent($query)
    {
        return $query->where('active', true)->first();
    }

    /**
     * Methods
     */

    public static function isActive()
    {
        return count(static::where('active', true)->get()) > 0;
    }

    /**
     * Relationships
     */

    public function applications()
    {
        return $this->hasMany(Application::class, 'cycle_id');
    }
}
