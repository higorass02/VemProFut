<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            "name" => 'required|string|max:255',
            "alias" => 'string|max:255',
            "gender" => 'string|max:1',
            "phone" => 'string|max:255',
            "email" => 'required|string|email|max:255|unique:users,email',
            "password" => 'string|min:8',
            "dt_birthdate" => 'string'
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
