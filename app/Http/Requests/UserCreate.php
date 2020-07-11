<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserCreate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $model = new User();

        return [
            'steamid' => 'required|unique:' . $model->getTable() . ',steamid',
            'nickname' => 'required|unique:' . $model->getTable() . ',nickname',
            'email' => 'required|email|unique:' . $model->getTable() . ',email',
            'password' => 'required|min:6',
            'auth_key' => 'required|min:15',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Вы не указали логин.',
            'password.required' => 'Вы не указали пароль.',
            'email.exists' => 'Неправильный логин или пароль.',
        ];
    }
}
