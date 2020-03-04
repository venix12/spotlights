<?php

namespace App\Http\Controllers;

use App\Event;
use App\Group;
use App\User;
use App\UserGroup;

class OsuOauthController extends Controller
{
    public function getOauthRedirect()
    {
        return app('osu-oauth')->authorize();
    }

    public function handleCallback()
    {
        $token = app('osu-oauth')->getToken();
        $userData = app('osu-oauth')->getUserData($token);

        $user = User::where('osu_user_id', $userData['id'])->first();

        if ($user === null)
        {
            $user = User::createFromApi($userData);

            UserGroup::create([
                'group_id' => Group::byIdentifier('default')->id,
                'user_id' => $user->id,
            ]);
        }

        if ($user->username !== $userData['username'])
        {
            Event::log("Changed username from {$user->username}", $user->id);

            $user->update(['username' => $userData['username']]);
        }

        auth()->login($user);

        if (!$user->has_logged_in)
        {
            $user->update([
                'has_logged_in' => true,
                'has_logged_in_at' => now(),
            ]);

            Event::log('Logged in for the first time');
        }

        return redirect('home');
    }
}
