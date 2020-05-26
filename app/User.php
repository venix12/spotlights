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
        'catch',
        'has_logged_in',
        'has_logged_in_at',
        'mania',
        'osu',
        'osu_user_id',
        'taiko',
        'user_group',
        'username',
    ];


    protected $hidden = [
        'remember_token',
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
        if ($this->active === false) {
            return self::INACTIVE_COLOUR;
        }

        $highestColor = $this->highestGroup()->group_color;

        if ($highestColor === '#') {
            return;
        }

        return $highestColor;
    }

    public function getGroupsAttribute()
    {
        return $this->groups()->orderByRaw('-hierarchy DESC')->get();
    }

    public function getTitleAttribute()
    {
        return $this->highestGroup()->title ?? null;
    }

    /**
     * Methods
     */

    public function authUserResponse()
    {
        $userItem = fractal_transform($this, 'UserTransformer', ['is_admin'], true);

        return $userItem;
    }

    public function availableAppModes()
    {
        $availableModes = [];

        foreach (self::MODES as $mode)
        {
            if (!$this->isApplying($mode)) {
                $availableModes[] = $mode;
            }
        }

        return $availableModes;
    }

    public static function createFromApi(array $response) {
        $user = static::create([
            'osu_user_id' => $response['id'],
            'username' => $response['username'],
        ]);

        return $user;
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

    public function hasPermSet(string $permission) : bool
    {
        return count($this->groups->where('perm_set', $permission)) > 0;
    }

    public function highestGroup()
    {
        return $this->groups->first();
    }

    public function spotlightsActivity(int $spotlights_id)
    {
        $nominations = $this->nominations->where('spots_id', $spotlights_id);
        $votes = $this->votes->where('spots_id', $spotlights_id);

        $comments = $this->votes->whereIn('nomination_id', $nominations->pluck('id'));

        $activity = count($nominations) + count($votes) - count($comments);

        return $activity;
    }

    /**
     * Checks
     */

    public function isActive()
    {
        return $this->active === true;
    }

    public function isAdmin()
    {
        return $this->hasPermSet('admin');
    }

    public function isApplicant()
    {
        return $this->hasPermSet('applicant');
    }

    public function isAppEvaluator()
    {
        return $this->hasPermSet('app-eval') || $this->isAdminOrManager();
    }

    public function isApplying($mode)
    {
        return count($this->groups->where('identifier', "applicant_{$mode}")) > 0;
    }

    public function isAdminOrManager()
    {
        return $this->isAdmin() || $this->isManager();
    }

    public function isManager()
    {
        return $this->hasPermSet('manager');
    }

    public function isMember()
    {
        return $this->isActive() && ($this->hasPermSet('member') || $this->isAdminOrManager());
    }

    /**
     * Scopes
     */

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }

    /**
     * Relationships
     */

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups');
    }

    public function nominations()
    {
        return $this->hasMany(SpotlightsNomination::class, 'user_id');
    }

    public function votes()
    {
        return $this->hasMany(SpotlightsNominationVote::class, 'user_id');
    }

}
