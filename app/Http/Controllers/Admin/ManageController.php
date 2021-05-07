<?php

namespace App\Http\Controllers\Admin;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_team_leader');
    }

    public function index()
    {
        $adminSections = [
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
            [
                'title' => 'Manage season leaderboards',
                'route' => 'admin.seasons',
            ],
        ];

        $managerSections = [
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
                'route' => 'admin.log',
            ]
        ];

        $sections = [
            [
                'title' => 'Manage members',
                'route' => 'admin.add-member',
            ],
            [
                'title' => 'Application evaluations',
                'route' => 'admin.app-eval',
            ],
            [
                'title' => 'Playlist composer',
                'route' => 'admin.playlist-composer.seasons',
            ]
        ];

        return view('admin.manage')
            ->with('adminSections', $adminSections)
            ->with('managerSections', $managerSections)
            ->with('sections', $sections);
    }
}
