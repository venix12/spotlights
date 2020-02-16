<?php

namespace App\Http\Controllers;

use App\Application;
use App\AppAnswer;
use App\AppCycle;
use App\AppQuestion;
use App\Event;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $questions = AppQuestion::active()->get();

        return view('app.form', compact('questions'));
    }

    public function store()
    {
        if (!AppCycle::isActive())
        {
            return redirect()->back();
        }

        $fields = request()->all();

        $app = Application::create([
            'cycle_id' => AppCycle::current()->id,
            'gamemode' => $fields['gamemode'],
            'user_id' => auth()->user()->id,
        ]);

        foreach ($fields as $key => $value)
        {
            if ($key !== '_token' && $key !== 'gamemode') {
                AppAnswer::create([
                    'answer' => $value,
                    'app_id' => $app->id,
                    'question_id' => $key,
                ]);
            }
        }

        Event::log('Applied for gamemode ' . gamemode($fields['gamemode']));

        return redirect()->back()
            ->with('success', 'Successfully submitted an application!');
    }
}
