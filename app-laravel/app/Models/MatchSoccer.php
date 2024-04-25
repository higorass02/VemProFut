<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchSoccer extends Model
{
    use SoftDeletes;
    const STATUS_FINISHED = 0;
    const STATUS_CREATED = 1;
    const STATUS_IN_PROGRESS = 2;
    protected $fillable = [
        'user_id',
        'status',
    ];

    protected $hidden = [];

    protected $casts = [];
    protected $table = 'matches_soccer';

    public function getStatus() : array {
        return [
            self::STATUS_FINISHED,
            self::STATUS_CREATED,
            self::STATUS_IN_PROGRESS
        ];
    }
}
