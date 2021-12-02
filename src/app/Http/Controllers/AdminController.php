<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\AdminUser;
use App\Question;
use App\BigQuestion;
use Illuminate\Foundation\Console\Presets\React;

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
}
