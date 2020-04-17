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

    public function editQuestion($id) {
        $question = AppQuestion::find($id);

        return view('admin.manage-app.edit')
            ->with('question', $question);
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
        $order = AppQuestion::orderBy('order', 'desc')->first()->order + 1;

        AppQuestion::create([
            'char_limit' => request()->char_limit,
            'description' => request()->description,
            'order' => $order,
            'question' => request()->question,
            'parent_id' => request()->parent_id,
            'relation_type' => request()->relation,
            'required' => request()->required ? true : false,
            'type' => request()->type,
        ]);

        Event::log('Created a new question ' . request()->question);

        return redirect()->back()
            ->with('success', 'Successfully added a question!');
    }

    public function updateQuestion($id)
    {
        $question = AppQuestion::find($id);

        $question->update([
            'char_limit' => request()->char_limit,
            'description' => request()->description,
            'question' => request()->question,
            'parent_id' => request()->parent_id,
            'relation_type' => request()->relation,
            'type' => request()->type,
        ]);

        Event::log("Edited a question {$question->question}");

        return redirect(route('admin.app'))
            ->with('success', 'successfully updated a question!');
    }
}
