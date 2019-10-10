<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    public function index()
    {
        if(!Auth::check())
        {
            return redirect('/');
        }

        $users = User::orderBy('username')->get();

        $activeUsers = $users->where('active', true);
        $inactives = $users->where('active', false);
        $admins = $activeUsers->where('group_id', 1);
        $leaders = $activeUsers->where('group_id', 2);
        $managers = $activeUsers->where('group_id', 3);
        $members = $activeUsers->where('group_id', 0);
        $usersNotLogged = $activeUsers->where('has_logged_in', false);

        return view('user.userlist')
            ->with('admins', $admins)
            ->with('inactives', $inactives)
            ->with('leaders', $leaders)
            ->with('managers', $managers)
            ->with('members', $members)
            ->with('usersNotLogged', $usersNotLogged);
    }
}
