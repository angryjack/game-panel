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
        $id = $this->input('id');
        $model = User::findOrFail($id);

        return [
            'name' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'email' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'auth_key' => 'required|min:15',
            'steam_id' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'nickname' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'role' => 'required',
            'flags' => 'required',
            'password' => 'nullable|min:6',
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
