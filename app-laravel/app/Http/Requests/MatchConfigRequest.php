<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchConfigRequest extends FormRequest
{
    public function rules()
    {
        return [
            "match_id" => 'required|numeric',
            "goal_keeper_fix" => 'required|numeric|max:1',
            "prioritize" => 'required|numeric|max:1',
            "max_playes_line" => 'required|numeric|max:1',
            "distinct_team" => 'required|numeric|max:1',
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
