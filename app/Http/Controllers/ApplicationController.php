<?php

namespace App\Http\Controllers;

use App\Application;
use App\AppAnswer;
use App\AppCycle;
use App\AppQuestion;
use App\Event;
use App\Events\ApplicationSubmitted;
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
        $questions = AppQuestion::active()
            ->with('children')
            ->orderBy('order')
            ->get();

        $questionsCollection = fractal_transform($questions, 'AppQuestionTransformer');

        $availableModes = auth()->user()->availableAppModes();

        return view('app.form')
            ->with('questionsCollection', $questionsCollection)
            ->with('availableModes', $availableModes);
    }

    public function store()
    {
        if (!AppCycle::isActive())
        {
            return redirect()->back();
        }

        $gamemode = request()->gamemode;

        if (auth()->user()->isApplying($gamemode))
        {
            return json_error('You\'ve applied for this gamemode in this cycle already!');
        }

        $app = Application::create([
            'cycle_id' => AppCycle::current()->id,
            'gamemode' => $gamemode,
            'user_id' => auth()->id(),
        ]);

        $questionIds = AppQuestion::active()->pluck('id')->toArray();

        foreach (request()->answers as $answer) {
            if (in_array($answer['id'], $questionIds)) {
                if ($answer['answer'] === null) {
                    return json_error('You have to fill all of the required fields!');
                }

                if ($answer['answer'] !== null) {
                    AppAnswer::create([
                        'answer' => $answer['answer'],
                        'app_id' => $app->id,
                        'question_id' => $answer['id'],
                    ]);
                }
            }
        }

        UserGroup::create([
            'group_id' => Group::byIdentifier("applicant_{$gamemode}")->id,
            'user_id' => auth()->id(),
        ]);

        event(new ApplicationSubmitted($app));

        Event::log('Applied for gamemode ' . gamemode($gamemode));
    }
}
