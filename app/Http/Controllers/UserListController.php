<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;

class UserListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admins = Group::byIdentifier('admin')->members;
        $managers = Group::byIdentifier('manager')->members;
        $members = Group::byIdentifier('member')->members;

        $membersArray = [
            'managers' => [
                'users' => $managers,
                'title' => 'Managers',
            ],
            'members' => [
                'users' => $members,
                'title' => 'Members',
            ]
        ];

        return view('user.userlist')
            ->with('membersArray', $membersArray);
    }
}
