<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Event;
use App\User;
use Illuminate\Http\Request;

class EventLoggerController extends Controller
{
    public function index()
    {
        if(!Auth::check() || !(Auth::user()->isAdmin() || Auth::user()->isManager()))
        {
            return redirect('/');
        }

        $events = Event::orderBy('id', 'DESC')->get();
        $users = User::all();
        
        return view('admin.eventlogger')
            ->with('events', $events)
            ->with('users', $users);
    }
}
