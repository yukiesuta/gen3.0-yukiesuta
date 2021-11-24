<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\AdminUser;
use App\Question;
use App\BigQuestion;

class AdminController extends Controller
{
    public function loginIndex() {
        return view('admin.login');
    }

    public function loginPost(Request $request) {
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
        dd(Question::find($id)->image);
    }
}
