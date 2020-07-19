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
            'name' => 'required|unique:' . $model->getTable() . ',name',
            'email' => 'required|email|unique:' . $model->getTable() . ',email',
            'steam_id' => 'required|unique:' . $model->getTable() . ',steam_id',
            'nickname' => 'required|unique:' . $model->getTable() . ',nickname',
            'auth_key' => 'required|min:15',
            'password' => 'required|min:6',
            'role' => 'required',
            'flags' => 'required',
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
