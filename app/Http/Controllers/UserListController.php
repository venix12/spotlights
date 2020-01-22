<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // TODO: move to model?
        $users = User::orderBy('username')->get();

        $activeUsers = $users->where('active', true);
        $inactives = $users->where('active', false);
        $admins = $activeUsers->where('group_id', 1);
        $leaders = $activeUsers->where('group_id', 2);
        $managers = $activeUsers->where('group_id', 3);
        $members = $activeUsers->where('group_id', 0);
        $usersNotLogged = $activeUsers->where('has_logged_in', false);

        $membersArray = [
            'admins' => [
                'colour' => User::GROUP_COLOURS[1],
                'users' => $admins->merge($leaders),
                'title' => 'Administrators',
            ],
            'managers' => [
                'colour' => User::GROUP_COLOURS[3],
                'users' => $managers,
                'title' => 'Managers',
            ],
            'members' => [
                'colour' => User::GROUP_COLOURS[0],
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
            'users_not_logged' => [
                'colour' => '',
                'users' => $usersNotLogged,
                'title' => 'Users that haven\'t logged in yet',
            ]
            ];

        return view('user.userlist')
            ->with('membersArray', $membersArray)
            ->with('moderationArray', $moderationArray);
    }
}
