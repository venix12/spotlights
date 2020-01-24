<?php

namespace App;

use Auth;
use App\SpotlightsNomination;
use App\SpotlightsNominationVote;
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
        1 => '#ff0000',
        2 => '#ff0000',
        3 => '#f56e20'
    ];

    const INACTIVE_COLOUR = '#747474';

    const MODES = [
        'osu',
        'catch',
        'mania',
        'taiko'
    ];

    const MODES_NAMES = [
        'osu' => 'osu!',
        'taiko' => 'osu!taiko',
        'catch' => 'osu!catch',
        'mania' => 'osu!mania'
    ];

    protected $fillable = [
        'osu_user_id', 'password', 'user_group', 'username', 'osu', 'taiko', 'catch', 'mania',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
        'catch' => 'boolean',
        'has_logged_in' => 'boolean',
        'mania' => 'boolean',
        'osu' => 'boolean',
        'taiko' => 'boolean',
    ];

    /**
     * Attributes
     */

    public function getColorAttribute()
    {
        return $this->highestGroup()->group_color ?? '#000000';
    }

    public function getTitleAttribute()
    {
        return $this->highestGroup()->title;
    }

    /**
     * Methods
     */

    public function getSpotlightActivity(int $spotlights_id)
    {
        $nominations = SpotlightsNomination::currentUserSpots($this->id, $spotlights_id)->get();
        $votes = SpotlightsNominationVote::currentUserSpots($this->id, $spotlights_id)->get();

        $activity = count($nominations) + count($votes);

        return $activity;
    }

    public function getUserModes()
    {
        $modes = [];

        foreach (self::MODES as $mode) {
            if ($this->$mode === true) {
                $modes[] = self::MODES_NAMES[$mode];
            }
        }

        return $modes;
    }

    public function groupIds()
    {
        return $this->userGroups->pluck('group_id')->toArray();
    }

    public function groups()
    {
        $groupIds = $this->groupIds();

        $userGroups = Group::whereIn('id', $groupIds)->get();

        return $userGroups->sortBy('hierarchy');
    }

    public function hasPermSet($permission) : bool
    {
        return count($this->groups()->where('perm_set', $permission)) > 0;
    }

    public function highestGroup()
    {
        return $this->groups()->first();
    }

    public function isMember() : bool
    {
        return $this->group_id === 0;
    }

    public function isAdmin() : bool
    {
        return $this->group_id === 1 || $this->group_id === 2;
    }

    public function isAdminOrManager() : bool
    {
        return $this->group_id === 1 || $this->group_id === 2 || $this->group_id === 3;
    }

    public function isManager() : bool
    {
        return $this->group_id === 3;
    }

    public function userGroups()
    {
        return $this->hasMany(UserGroup::class);
    }
}
