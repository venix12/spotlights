<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

class RegisteredUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin_or_manager');
    }

    public function index()
    {
        $users = User::all();

        return view('admin.userlist')->with('users', $users);
    }
}
