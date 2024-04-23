<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    protected $fillable = [
        'user_id',
        'match_id',
        'team_number',
        'status'
    ];

    protected $hidden = [];

    protected $casts = [
        'user_id' => User::class,
        'match_id' => MatchSoccer::class
    ];
    protected $table = 'team';

    public function getStatus() : array {
        return [
            self::STATUS_DISABLED,
            self::STATUS_ENABLED
        ];
    }
}
