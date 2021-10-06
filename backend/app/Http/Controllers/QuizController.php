<?php

namespace App\Http\Controllers;

use App\Question;
use App\Choice;

class QuizController extends Controller
{
    public function index($id) {
        $questions = Choice::where('question_id', $id)
                    ->groupBy('group')
                    ->select('group')
                    ->get();
        $choices = Question::find($id)->choices;
        return view('index', compact('questions', 'choices'));
    }
}
