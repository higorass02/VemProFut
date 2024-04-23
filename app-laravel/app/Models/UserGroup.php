<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UserGroup extends Model
{

    protected $table = 'users_groups';
    protected $fillable = [
        'status',
        'user_id',
        'group_id',
    ];
    protected $hidden = [];
    protected $casts = [
        'user_id' => User::class,
        'group_id' => Group::class
    ];
}
