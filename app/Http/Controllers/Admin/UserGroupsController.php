<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;

class UserGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function addMember($id, Request $request)
    {
        $group = Group::find($id);
        $user = User::where('username', $request->username)->first();

        UserGroup::create([
            'group_id' => $id,
            'user_id' => $user->id,
        ]);

        Event::log("Added user {$user->username} to usergroup {$group->identifier}");

        return redirect()->back();
    }

    public function create()
    {
        return view('admin.user-groups.create');
    }

    public function index()
    {
        $groups = Group::all();

        return view('admin.user-groups.index')
            ->with('groups', $groups);
    }

    public function show($id)
    {
        $group = Group::find($id);

        if (!$group)
        {
            return redirect('/');
        }

        return view('admin.user-groups.show')
            ->with('group', $group);
    }

    public function store(Request $request)
    {
        $group = Group::create([
            'color' => $request->color,
            'hidden' => $request->hidden ? true : false,
            'hierarchy' => $request->hierarchy,
            'identifier' => $request->identifier,
            'name' => $request->name,
            'perm_set' => $request->perm_set,
            'title' => $request->title,
        ]);

        Event::log("Created usergroup {$group->identifier}");

        return redirect(route('admin.user-groups'));
    }

    public function removeMember($id, Request $request)
    {
        $group = Group::find($id);
        $user = User::find($request->user_id);

        $user_group = UserGroup::where('group_id', $id)
            ->where('user_id', $request->user_id)
            ->first();

        $user_group->delete();

        Event::log("Removed user {$user->username} from usergroup {$group->identifier}");

        return redirect()->back();
    }
}
