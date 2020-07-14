<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage()
    {
        return view('site.signin');
    }

    public function login(Login $request)
    {
        $credentials = $request->only('login', 'password');

        $user = User
            ::where('name', $credentials['login'])
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
