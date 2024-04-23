<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MatchConfig extends Model
{
    const TEAM_DISTINCT_NUMBER = 0;
    const TEAM_DISTINCT_COLOR = 1;
    protected $fillable = [
        'match_id',
        'goal_keeper_fix',
        'prioritize_payers',
        'max_playes_line',
        'type_sortition',
        'distinct_team'
    ];

    protected $hidden = [];

    protected $casts = [
        'goal_keeper_fix' => 'boolean',
        'prioritize_payers' => 'boolean',
        'match_id' => MatchSoccer::class,
        'max_playes_line' => 'Integer'
    ];
    protected $table = 'matches_config';
}
