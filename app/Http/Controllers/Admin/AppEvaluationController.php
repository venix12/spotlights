<?php

namespace App\Http\Controllers\admin;

use App\AppCycle;
use App\Application;
use App\Event;

class AppEvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->only([
            'approveFeedback',
            'createCycle',
            'storeCycle',
        ]);

        $this->middleware('is_admin_or_manager');
    }

    public function approveFeedback($id)
    {
        $app = Application::find($id);

        $app->update(['approved' => true]);

        Event::log("Approved feedback for {$app->user->username}");

        return;
    }

    public function createCycle()
    {
        return view('admin.app-eval.create-cycle');
    }

    public function index()
    {
        $cycles = AppCycle::with('applications')->get();

        return view('admin.app-eval.index')
            ->with('cycles', $cycles);
    }

    public function show($id)
    {
        $cycle = AppCycle::with('applications')
            ->with('applications.answers')
            ->with('applications.answers.question')
            ->with('applications.feedbackAuthor')
            ->with('applications.user')
            ->find($id);

        $apps = $cycle->applications;

        $appsCollection = fractal_transform($apps, 'ApplicationTransformer');

        return view('admin.app-eval.show')
            ->with('appsCollection', $appsCollection)
            ->with('cycle', $cycle);
    }

    public function storeCycle()
    {
        AppCycle::create([
            'deadline' => request()->deadline . ' 23:59:59',
            'name' => request()->name,
            'user_id' => auth()->user()->id,
        ]);

        Event::log('Created app cycle ' . request()->name);

        return redirect(route('admin.app-eval'))
            ->with('success', 'Successfully created an app cycle!');
    }

    public function storeFeedback($id)
    {
        $app = Application::find($id);

        $app->update([
            'feedback' => request()->feedback,
            'feedback_author_id' => auth()->user()->id,
            'verdict' => request()->verdict,
        ]);

        Event::log("Submitted a feedback for {$app->user->username}");

        return fractal_transform($app, 'ApplicationTransformer', null, true);
    }
}
