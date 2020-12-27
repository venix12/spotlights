<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;

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
            ->paginate(150);

        return view('admin.log')
            ->with('events', $events);
    }
}
