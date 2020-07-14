<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => 'required|exists:users,name',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'Вы не указали логин.',
            'password.required' => 'Вы не указали пароль.',
            'login.exists' => 'Пользователь с таким логином не найден.',
        ];
    }
}
