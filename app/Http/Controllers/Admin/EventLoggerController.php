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
        $events = Event::with('user')
            ->orderBy('id', 'DESC')
            ->paginate(50);

        return view('admin.log')
            ->with('events', $events);
    }
}
