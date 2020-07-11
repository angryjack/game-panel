<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $model = new User();

        return [
            'steamid' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'nickname' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'email' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
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
