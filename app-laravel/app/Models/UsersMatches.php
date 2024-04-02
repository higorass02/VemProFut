<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UsersMatches extends Model
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    protected $fillable = [
        'user_id',
        'match_id',
    ];

    protected $hidden = [];

    protected $casts = [];
    protected $table = 'users_matches';

    public function getStatus() : array {
        return [
            self::STATUS_DISABLED,
            self::STATUS_ENABLED
        ];
    }
}
