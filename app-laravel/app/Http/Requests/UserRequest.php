<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            "name" => 'required|string|max:255',
            "apelido" => 'string|max:255',
            "sexo" => 'string|max:1',
            "celular" => 'string|max:255',
            "email" => 'required|string|email|max:255|unique:users,email,',
            "password" => 'string|min:8',
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