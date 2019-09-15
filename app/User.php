<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'user_group'
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

    public function getName()
    {
        $namedUsers = self::all();

        $name = [];

        foreach($namedUsers as $namedUser)
        {
            if ($namedUser->id == 2)
            {
                $name[] = $namedUser->username;
            }
            
             //$namedUser->where('username', $user->username)->username;
        }

        //return $this->username;
        return $name;

    }
}
