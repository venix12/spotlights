<?php

namespace App\Http\Controllers\Admin;

use App\AppQuestion;
use App\Event;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function create()
    {
        $questions = AppQuestion::orderBy('order')->get();
        $questionsActive = $questions->where('active', true);
        $questionsDeleted = $questions->where('active', false);

        return view('admin.manage-app.create')
            ->with('questionsActive', $questionsActive)
            ->with('questionsDeleted', $questionsDeleted);
    }

    public function deleteOrRevertQuestion()
    {
        $question = AppQuestion::find(request()->question_id);
        $question->update(['active' => $question->active ? false : true]);

        return redirect()->back()
            ->with('success', 'Successfully changed a question!');
    }

    public function moveAround($direction) {
        $selectedQuestion = AppQuestion::find(request()->id);

        $secondQuestion = AppQuestion::active()
            ->where('order', $direction === 'up' ? '<' : '>', $selectedQuestion->order)
            ->orderBy('order', $direction === 'up' ? 'desc' : 'asc')
            ->first();

        $newOrder = $secondQuestion->order;

        $secondQuestion->update(['order' => $selectedQuestion->order]);
        $selectedQuestion->update(['order' => $newOrder]);

        return redirect()->back()
            ->with('success', 'Successfully changed the order!');
    }

    public function storeQuestion()
    {
        if (AppQuestion::where('order', request()->order_value)->exists() !== false) {
            return redirect()->back()
                ->with('error', 'A question with the same order value already exists!');
        }

        AppQuestion::create([
            'char_limit' => request()->char_limit,
            'order' => request()->order_value,
            'question' => request()->question,
            'required' => request()->required ? true : false,
            'type' => request()->type,
        ]);

        Event::log('Created a new question ' . request()->question);

        return redirect()->back()
            ->with('success', 'Successfully added a question!');
    }
}
