<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use Auth;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin_or_manager');
    }

    public function index()
    {
        $adminSections = [
            [
                'title' => 'Add new member',
                'route' => 'admin.add-member',
            ],
            [
                'title' => 'Create new spotlights',
                'route' => 'admin.newSpotlights',
            ],
            [
                'title' => 'Manage app',
                'route' => 'admin.app',
            ],
            [
                'title' => 'Manage usergroups',
                'route' => 'admin.user-groups',
            ],
        ];

        $sections = [
            [
                'title' => 'Manage Spotlights',
                'route' => 'admin.spotlist',
            ],
            [
                'title' => 'Manage Users',
                'route' => 'admin.userlist',
            ],
            [
                'title' => 'Log',
                'route' => 'admin.log'
            ]
        ];

        return view('admin.manage')
            ->with('adminSections', $adminSections)
            ->with('sections', $sections);
    }
}
