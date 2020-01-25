<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{
    protected $casts = [
        'hidden' => 'boolean',
    ];

    /**
     * Attributes
     */

    public function getGroupColorAttribute()
    {
        return "#{$this->color}";
    }

    /**
     * Methods
     */

    public function membersCount()
    {
        return count($this->members);
    }

    /**
     * Scopes
     */

    public function scopeByIdentifier($query, $identifier)
    {
        return $query->where('identifier', $identifier)->first();
    }

    public function scopeVisible($query)
    {
        return $query->where('hidden', false);
    }

    /**
     * Relationships
     */

    public function members()
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }
}
