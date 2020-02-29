<?php

namespace App\Http\Controllers;

use App\Application;
use App\AppAnswer;
use App\AppCycle;
use App\AppQuestion;
use App\Event;
use App\Group;
use App\UserGroup;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $questions = AppQuestion::active()->get();

        $availableModes = auth()->user()->availableAppModes();

        return view('app.form')
            ->with('questions', $questions)
            ->with('availableModes', $availableModes);
    }

    public function store()
    {
        if (!AppCycle::isActive())
        {
            return redirect()->back();
        }

        $fields = request()->all();

        if (auth()->user()->isApplying($fields['gamemode']))
        {
            return redirect()->back()
                ->with('error', 'You\'ve applied for this gamemode in this cycle already!');
        }

        $app = Application::create([
            'cycle_id' => AppCycle::current()->id,
            'gamemode' => $fields['gamemode'],
            'user_id' => auth()->user()->id,
        ]);

        $questionIds = AppQuestion::active()->pluck('id');

        foreach ($fields as $key => $value)
        {
            if (in_array($key, $questionIds)) {
                $question = AppQuestion::find($key);

                if ($question->required === true && $value === null) {
                    return redirect()->back()
                        ->with('error', 'You have to fill all of the required fields!');
                }

                if ($value !== null) {
                    AppAnswer::create([
                        'answer' => $value,
                        'app_id' => $app->id,
                        'question_id' => $key,
                    ]);
                }
            }
        }

        UserGroup::create([
            'group_id' => Group::byIdentifier("applicant_{$fields['gamemode']}")->id,
            'user_id' => auth()->id(),
        ]);

        Event::log('Applied for gamemode ' . gamemode($fields['gamemode']));

        return redirect()->back()
            ->with('success', 'Successfully submitted an application!');
    }
}
