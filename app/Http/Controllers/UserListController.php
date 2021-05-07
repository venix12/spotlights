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
        $inactives = User::inactive()->orderBy('username')->get();

        $admins = Group::byIdentifier('admin')->members;
        $managers = Group::byIdentifier('manager')->members;
        $members = Group::byIdentifier('member')->members;

        $membersArray = [
            'admins' => [
                'users' => $admins,
                'title' => 'Administrators',
            ],
            'managers' => [
                'users' => $managers,
                'title' => 'Managers',
            ],
            'members' => [
                'users' => $members,
                'title' => 'Members',
            ]
        ];

        $moderationArray = [
            'inactives' => [
                'colour' => User::INACTIVE_COLOUR,
                'users' => $inactives,
                'title' => 'Inactive users',
            ],
        ];

        return view('user.userlist')
            ->with('membersArray', $membersArray)
            ->with('moderationArray', $moderationArray);
    }
}
