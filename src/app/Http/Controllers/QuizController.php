<?php

namespace App\Http\Controllers;

use App\Models\BigQuestion;
use App\Models\Question;

class QuizController extends Controller
{
    public function index() 
    {
        $questions = Question::all();
        return view('quiz.index', compact('questions'));
    }

    public function detail($id)
    {
        $bigQuestion = BigQuestion::with('questions.choices')->find($id);
        return view('quiz.detail', compact('bigQuestion'));
    }
}
