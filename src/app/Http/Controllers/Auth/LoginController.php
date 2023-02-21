<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password'        => 'required|string',
        ]);
    }

    protected function redirectTo()
    {
        $role_id = Auth::user()->role_id;
        $role=Role::where('id',$role_id)->first()->name;
        $user_name = Auth::user()->name;
        session()->put('role',$role);
        session()->put('user_name',$user_name);
        
        if ($role_id === Role::getAdminId() || $role_id === Role::getDeliveryAgentId()) {
            return '/delivery-list';
        } else {
            return '/';
        }
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }
}
