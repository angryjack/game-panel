<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdate extends FormRequest
{
    public function authorize()
    {
        return Auth::user() !== null;
    }

    public function rules()
    {
        /** @var User $user */
        $model = Auth::user();

        return [
            'steam_id' => [
                'sometimes',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'nickname' => [
                'sometimes',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'password' => 'nullable|min:6',
        ];

    }

    public function messages()
    {
        return [
            'steam_id.required' => 'Вы не указали Steam ID.',
            'steam_id.unique' => 'Steam ID уже занят другим игроком.',
            'nickname.required' => 'Вы не указали ник.',
            'nickname.unique' => 'Ник уже занят другим игроком.',
            'password.min' => 'Минимальная длина пароль 6 символов.',
        ];
    }
}
