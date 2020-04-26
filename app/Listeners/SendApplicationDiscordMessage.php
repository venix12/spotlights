<?php

namespace App\Listeners;

use App\AppCycle;
use App\Events\ApplicationSubmitted;
use Guzzle;

class SendApplicationDiscordMessage
{
    /**
     * Handle the event.
     *
     * @param  ApplicationSubmitted  $event
     * @return void
     */
    public function handle(ApplicationSubmitted $event)
    {
        $destination = env('WEBHOOK_APPLICATIONS');

        if ($destination === null) {
            return;
        }

        $app = $event->app;
        $gamemode = gamemode($app->gamemode);

        Guzzle::post($destination, [
            'json' => [
                'embeds' => [[
                    'color' => 3066993,
                    'description' => "**[{$app->user->username}](https://osu.ppy.sh/users/{$app->user->osu_user_id})** has just submitted an application!",
                    'fields' => [[
                        'name' => 'gamemode',
                        'value' => $gamemode,
                    ]],
                    'title' => 'New application submitted!',
                    'thumbnail' => [
                        'url' => "https://a.ppy.sh/{$app->user->osu_user_id}",
                    ],
                    'url' => route('admin.app-eval.show', AppCycle::current()->id),
                ]],
            ],
        ]);
    }
}
