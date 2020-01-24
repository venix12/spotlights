<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{
    protected $casts = [
        'hidden' => 'boolean',
    ];

    public function getGroupColorAttribute()
    {
        return "#{$this->color}";
    }

    public function members()
    {
        $userIds = $this->userIds();

        return User::whereIn('id', $userIds)->get();
    }

    public function membersCount()
    {
        return count($this->userIds());
    }

    public function scopeByIdentifier($query, $identifier)
    {
        return $query->where('identifier', $identifier)->first();
    }

    public function scopeVisible($query)
    {
        return $query->where('hidden', false);
    }

    public function userIds()
    {
        return $this->userGroups->pluck('user_id');
    }

    public function userGroups()
    {
        return $this->hasMany(UserGroup::class, 'group_id');
    }
}
