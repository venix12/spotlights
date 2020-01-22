<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\User;
use Illuminate\Http\Request;

class EventLoggerController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin_or_manager');
    }

    public function index()
    {
        $events = Event::orderBy('id', 'DESC')->get();
        $users = User::all();

        return view('admin.eventlogger')
            ->with('events', $events)
            ->with('users', $users);
    }
}
