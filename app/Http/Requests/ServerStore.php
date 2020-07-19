<?php

namespace App\Http\Requests;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServerStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        if ($id) {
            $model = Server::findOrFail($id);
            $addressRule = [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ];
        } else {
            $model = new Server();
            $addressRule = 'required|unique:' . $model->getTable() . ',address';
        }

        $rules = [
            'hostname' => 'required',
            'address' => $addressRule,
            'description' => 'sometimes',
            'rules' => 'sometimes',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'hostname.required' => 'Название сервера обязательно',
            'address.required' => 'IP сервера обязательно',
            'address.unique' => 'Данный IP уже добавлен',
        ];
    }
}
