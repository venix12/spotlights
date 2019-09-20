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
        
        $admins = $users->where('group_id', 1)->where('active', 1);
        $leaders = $users->where('group_id', 2)->where('active', 1);
        $managers = $users->where('group_id', 3)->where('active', 1);
        $members = $users->where('group_id', 0)->where('active', 1);

        return view('user.userlist')
            ->with('admins', $admins)
            ->with('leaders', $leaders)
            ->with('managers', $managers)
            ->with('members', $members);
    }
}
