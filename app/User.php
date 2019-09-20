<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const GROUPS = [
        0 => 'Member',
        1 => 'Administrator',
        2 => 'Project Leader',
        3 => 'Manager'
    ];

    const GROUP_COLOURS = [
        0 => '',
        1 => '#2e88e8',
        2 => '#ff0000',
        3 => '#f56e20',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'osu_user_id', 'password', 'user_group', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function isActive()
    {
        if (Auth::user()->active == 1)
        {
            return true;
        }
    }

    public function isMember()
    {
        if (Auth::user()->group_id == 0)
        {
            return true;
        }
    }

    public function isAdmin()
    {
        if (Auth::user()->group_id == 1)
        {
           return true;
        }
    }

    public function isLeader()
    {
       if (Auth::user()->group_id == 2)
       {
           return true;
       }
    }

    public function isManager()
    {
       if (Auth::user()->group_id == 3)
       {
           return true;
       }
    }

    public function group()
    {
        return $this->hasOne('UserGroup');
    }
}
