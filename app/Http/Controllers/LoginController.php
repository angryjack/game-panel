<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Login $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User
            ::where('email', $credentials['email'])
            ->where('password', md5($credentials['password']))
            ->first();

        if ($user) {
            Auth::login($user, true);
            return true;
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
