<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    protected $table = 'groups';
    protected $fillable = [
        'alias',
        'status',
        'user_id',
    ];
    protected $hidden = [];
    protected $casts = [
        'user_id' => User::class,
    ];
}
