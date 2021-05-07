<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Console\Command;

class SetDefaultUsergroupForNoUsergroupUsers extends Command
{
    protected $signature = 'usergroup:default';

    protected $description = 'Sets usergroup to default for all users that don\'t belong to any usergroup';

    public function handle()
    {
        $users = User::all()->filter(function ($user) {
            return $user->highestGroup() === null;
        });

        $bar = $this->output->createProgressBar(count($users));
        $bar->start();

        foreach ($users as $user) {
            UserGroup::create([
                'group_id' => Group::byIdentifier('default')->id,
                'user_id' => $user->id,
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->output->newLine();
    }
}
