<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
            return redirect()->route('home');
        }

        $validator = Validator::make([], []);
        $validator->getMessageBag()->add('password', 'Неправильный пароль.');
        return Redirect::back()->withErrors($validator)->withInput();
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
