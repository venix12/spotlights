<?php

namespace App\Http\Controllers\Admin;

use App\AppQuestion;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index()
    {
        $questions = AppQuestion::all();
        $questionsActive = $questions->where('active', true);
        $questionsDeleted = $questions->where('active', false);

        return view('admin.manage-app')
            ->with('questionsActive', $questionsActive)
            ->with('questionsDeleted', $questionsDeleted);
    }

    public function storeQuestion()
    {
        AppQuestion::create([
            'char_limit' => request()->char_limit,
            'question' => request()->question,
            'required' => request()->required ? true : false,
        ]);

        return redirect()->back()
            ->with('success', 'Successfully added a question!');
    }
}
