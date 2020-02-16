<?php

namespace App\Http\Controllers\admin;

use App\AppCycle;
use App\Application;

class AppEvaluationController extends Controller
{
    public function approveFeedback($id)
    {
        $app = Application::find($id);

        $app->update(['approved' => true]);

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

        return fractal_transform($app, 'ApplicationTransformer', null, true);
    }
}