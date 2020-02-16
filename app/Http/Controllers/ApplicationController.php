<?php

namespace App\Http\Controllers;

use App\Application;
use App\AppAnswer;
use App\AppCycle;
use App\AppQuestion;

class ApplicationController extends Controller
{
    public function index()
    {
        $questions = AppQuestion::active()->get();

        return view('app.form', compact('questions'));
    }

    public function store()
    {
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

        return redirect()->back()
            ->with('success', 'Successfully submitted an application!');
    }
}
