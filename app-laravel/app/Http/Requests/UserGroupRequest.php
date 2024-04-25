<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            "alias" => 'required|string|max:255',
            "user_id" => 'number',
            "group_id" => 'number'
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser preenchido com valores numéricos.',
            'string' => 'O campo :attribute deve ser preenchido com valores string.',
            'min:8' => 'O campo :attribute requer um mínimo de 5 caracteres.',
            'max:255' => 'O campo :attribute não pode exceder 255 caracteres.'
        ];
    }
}
