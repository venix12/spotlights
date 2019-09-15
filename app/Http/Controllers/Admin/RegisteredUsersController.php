<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\UserGroup;
use Auth;

class RegisteredUsersController extends Controller
{
    public function index()
    {
    if(!Auth::check() || !Auth::user()->isAdmin())
        {
            return redirect('/');
        }

    $users = User::all();

    return view('admin.userlist')->with('users', $users);
    }
}
