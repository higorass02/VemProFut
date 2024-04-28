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
    protected $casts = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
}
