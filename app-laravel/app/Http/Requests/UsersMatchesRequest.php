<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersMatchesRequest extends FormRequest
{
    public function rules()
    {
        return [
            "user_id" => 'required|numeric',
            "match_id" => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser preenchido com valores numéricos.',
            'string' => 'O campo :attribute deve ser preenchido com valores literal.',
            'min:8' => 'O campo :attribute requer um mínimo de 5 caracteres.',
            'max:255' => 'O campo :attribute não pode exceder 255 caracteres.'
        ];
    }
}
