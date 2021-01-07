<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const INACTIVE_COLOUR = '#747474';

    const MODES = [
        'osu',
        'taiko',
        'catch',
        'mania',
    ];

    const MODES_NAMES = [
        'osu' => 'osu!',
        'taiko' => 'osu!taiko',
        'catch' => 'osu!catch',
        'mania' => 'osu!mania',
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

    public function modesRaw()
    {
        $modes = [];

        foreach (self::MODES as $mode) {
            if ($this->$mode === true) {
                $modes[] = $mode;
            }
        }

        return $modes;
    }

    public function playlistComposerGamemodes()
    {
        if ($this->isAdmin()) {
            return self::MODES;
        }

        return $this->modesRaw();
    }

    public function seasonTotalScore(int $season_id)
    {
        $season = Season::find($season_id);
        $playlistIds = $season->playlists->pluck('id');

        $scores = $this->scores
            ->whereIn('playlist_id', $playlistIds);

        $playlistScores = [];

        foreach ($scores as $score) {
            $roomName = $score->playlist->osu_room_name;
            $totalScore = $score->total_score;

            if (!array_key_exists($roomName, $playlistScores) || $playlistScores[$roomName] < $totalScore) {
                $playlistScores[$roomName] = $totalScore;
            }
        }

        $indexedScores = array_values($playlistScores);

        rsort($indexedScores);

        $factors = $season->rawFactorsSorted();
        $totalScore = 0;

        for ($i = 0; $i < count($indexedScores); $i++)
        {
            $totalScore += $indexedScores[$i] * $factors[$i];
        }

        return $totalScore;
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
        return $this->hasPermSet('app-eval') || $this->isAdminOrManager() || $this->isTeamLeader();
    }

    public function isApplying($mode)
    {
        return $this->isGroup("applicant_{$mode}");
    }

    public function isAdminOrManager()
    {
        return $this->isAdmin() || $this->isManager();
    }

    public function isGroup($identifier)
    {
        return $this->groups
            ->where('identifier', $identifier)
            ->first() !== null;
    }

    public function isManager()
    {
        return $this->hasPermSet('manager');
    }

    public function isMember()
    {
        return $this->isActive() && ($this->hasPermSet('member') || $this->isAdminOrManager());
    }

    public function isTeamLeader()
    {
        return $this->isGroup('team_leaders');
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

    public function scores()
    {
        return $this->hasMany(Score::class, 'user_id');
    }

    public function votes()
    {
        return $this->hasMany(SpotlightsNominationVote::class, 'user_id');
    }

}
