<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MatchSoccer extends Model
{
    use SoftDeletes;
    const STATUS_FINISHED = 0;
    const STATUS_CREATED = 1;
    const STATUS_IN_PROGRESS = 2;
    protected $fillable = [
        'user_id',
        'group_id',
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
    public function config(): HasOne
    {
        return $this->hasOne(MatchConfig::class, 'match_id', 'id');
    }

    public function group(): ?HasOne
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
}
