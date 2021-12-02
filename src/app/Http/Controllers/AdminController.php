<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\AdminUser;
use App\Question;
use App\BigQuestion;
use App\Choice;

class AdminController extends Controller
{
    public function loginIndex() {
        return view('admin.login');
    }

    public function login(Request $request) {
        $userId = $request->userId;
        $password = $request->password;
        if (!AdminUser::where('user_id', $userId)->first()) {
            return redirect('/admin/login');
        }

        $adminPassword = AdminUser::where('user_id', $userId)->first()->password;
        if (Hash::check($password, $adminPassword)) {
            return redirect('/admin');
        } else {
            return redirect('/admin/login');
        }
    }

    public function index() {
        $big_questions = BigQuestion::all();;
        $questions = Question::all();
        return view('admin.index', compact('big_questions', 'questions'));
    }

    public function editIndex($id) {
        $question = Question::find($id);
        return view('admin.edit.id', compact('question'));
    }

    public function edit(Request $request, $id) {
        $choices = Question::find($id)->choices;
        foreach ($choices as $index => $choice) {
            $choice->name = $request->{'name'.$index};
            if ($index === intval($request->valid)) {
                $choice->valid = true;
            } else {
                $choice->valid = false;
            }
            $choice->save();
        }
        return redirect('/admin');
    }

    public function addIndex($id) {
        $big_question = BigQuestion::find($id);
        return view('admin.add.id', compact('big_question'));
    }

    public function add(Request $request, $id) {
        $file = $request->file;
        $fileName = $request->{'name'.$request->valid} . '.png';
        $path = public_path('img/');
        $file->move($path, $fileName);

        $question = new Question;
        $question->big_question_id = $id;
        $question->image = $fileName;
        $question->save();
        $question->choices()->saveMany([
            new Choice([
                'name' => $request->name1,
                'valid' => intval($request->valid) === 1,
            ]),
            new Choice([
                'name' => $request->name2,
                'valid' => intval($request->valid) === 2,
            ]),
            new Choice([
                'name' => $request->name3,
                'valid' => intval($request->valid) === 3,
            ]),
        ]);

        return redirect('/admin');
    }
}
