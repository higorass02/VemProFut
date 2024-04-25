<?php

namespace App\Casts;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UserCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        dd($value);
        if(isset($value)){
            return User::where($value)->get()->first();
        }
        return $value;
        
    }

    public function set($model, string $key, $value, array $attributes)
    {
        // return strtoupper($value);
    }
}