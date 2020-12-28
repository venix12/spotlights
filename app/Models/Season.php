<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'compose_seasons';

    protected $fillable = [
        'name',
    ];

    public function modePlaylists($modes)
    {
        return $this->playlists
            ->whereIn('mode', $modes);
    }

    public function validate()
    {
        $errors = [];

        foreach (User::MODES as $mode) {
            $entries = $this->playlists()
                ->where('mode', $mode)
                ->with('entries')
                ->get()
                ->pluck('entries')
                ->flatten();

            $expectedEntriesCount = 20; // TODO: make it database or env sourced if we happen to change it often?
            $entriesCount = $entries->count();

            if ($expectedEntriesCount !== $entriesCount) {
                $errors[$mode][] = "Wrong entries count, should be <b>{$expectedEntriesCount}</b> (current - <b>{$entriesCount}</b>).";
            }

            $recentlyRankedExpectedCount = $expectedEntriesCount * 0.25;
            $recentlyRankedCount = $entries->filter(function ($entry) {
                return Carbon::parse($entry->ranked_at)
                    ->diffInDays(Carbon::parse($this->release_date)) < 90;
            })->count();

            if ($recentlyRankedCount < $recentlyRankedExpectedCount) {
                $errors[$mode][] = "Wrong recently ranked maps count, should be at least <b>{$recentlyRankedExpectedCount}</b> (current - <b>{$recentlyRankedCount}</b>).";
            }

            $difficulties = [
                'hard' => $expectedEntriesCount * 0.25,
                'insane' => $expectedEntriesCount * 0.45,
                'expert' => $expectedEntriesCount * 0.3,
            ];

            foreach ($difficulties as $difficulty => $count) {
                $difficultyEntriesCount = $entries
                    ->where('difficulty', $difficulty)
                    ->count();

                if ($difficultyEntriesCount !== (int) $count) {
                    $errors[$mode][] = "Wrong <b>{$difficulty}</b> count, should be <b>{$count}</b> (current - <b>{$difficultyEntriesCount}</b>).";
                }
            }
        }

        return $errors;
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }
}
