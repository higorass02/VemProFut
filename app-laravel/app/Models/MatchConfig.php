<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MatchConfig extends Model
{
    const TEAM_DISTINCT_NUMBER = 0;
    const TEAM_DISTINCT_COLOR = 1;

    const TYPE_SORT_RANDOM = 0;
    const TYPE_SORT_MANUAL = 1;
    const TYPE_SORT_BALANCE = 2;
    
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
        'max_playes_line' => 'integer'
    ];
    protected $table = 'matches_config';
}
