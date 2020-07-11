<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PrivilegeCreate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {

        return [
            'id' => 'sometimes|exists:privileges',
            'title' => 'required',
            'flags' => [
                'required',
                Rule::unique('privileges')->where(function (Builder $query) use ($request) {
                    return $query
                        ->where('flags', $request->input('flags'))
                        ->where('server_id', $request->input('server_id'))
                        ->when($request->input('id'), function (Builder $q) use ($request) {
                            $q->where('id', '!=', $request->input('id'));
                        });
                })
            ],
            'server_id' => 'required',
            'rates' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Вы не указали название.',
            'flags.required' => 'Вы не указали Флаги доступа',
            'flags.unique' => 'Привилегия с таким доступом уже добавлена',
            'server_id.required' => 'Вы не указали сервер',
        ];
    }
}
