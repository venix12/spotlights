<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Group;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserGroup;

class AddMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_team_leader');
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
            $gamemode => $user->$gamemode === true ? false : true,
        ]);

        if (!$user->isMember()) {
            UserGroup::create([
                'group_id' => Group::byIdentifier('member')->id,
                'user_id' => $user->id,
            ]);
        }

        if ($user->getUserModes() === [] && $user->isMember()) {
            UserGroup::where('user_id', $user->id)
                ->where('group_id', Group::byIdentifier('member')->id)
                ->delete();
        }

        if ($user->$gamemode === true) {
            Event::log("Added user {$user->username} to " . gamemode($gamemode). ' members');

            return redirect()->back()
                ->with('success', 'Successfully added user to' . gamemode($gamemode) . 'members!');
        } else {
            Event::log("Removed user {$user->username} from " . gamemode($gamemode). ' members');

            return redirect()->back()
                ->with('success', 'Successfully removed user from' . gamemode($gamemode) . 'members!');
        }
    }
}
