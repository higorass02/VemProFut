<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use SoftDeletes, HasFactory;
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    protected $table = 'groups';
    protected $fillable = [
        'alias',
        'status',
        'user_id',
        'group_id'
    ];
    protected $hidden = [];
    protected $casts = [];

    public function user()
    {
        return $this->hasMany(Group::class, 'id', 'group_id');
    }
}
