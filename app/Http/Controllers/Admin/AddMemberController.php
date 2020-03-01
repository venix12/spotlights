<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use App\UserGroup;

class AddMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create()
    {
        return view('admin.add-member');
    }

    public function store()
    {
        $gamemode = request()->gamemode;
        $user = User::where('username', request()->username)->first();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'User not found!');
        }

        $user->update([
            $gamemode => true,
        ]);

        if (!$user->isMember()) {
            UserGroup::create([
                'group_id' => Group::byIdentifier('member')->id,
                'user_id' => $user->id,
            ]);
        }

        Event::log("Added user {$user->username} to " . gamemode($gamemode). ' members');

        return redirect()->back()
            ->with('success', 'Successfully added user to' . gamemode($gamemode) . 'members!');
    }
}
