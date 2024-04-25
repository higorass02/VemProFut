<?php

namespace App\Repositories;

use App\Models\MatchConfig;
use InvalidArgumentException;

class MatchConfigRepository
{
    private MatchConfig $model;

    public function __construct(?MatchConfig $model = null)
    {
        $this->model = $model ?? new MatchConfig();
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create($matchId, array $data)
    {
        $this->model->match_id = $matchId;
        $this->model->goal_keeper_fix = $data['goal_keeper_fix'];
        $this->model->prioritize_payers = $data['prioritize_payers'];
        $this->model->max_playes_line = $data['max_playes_line'];
        $this->model->distinct_team = $data['distinct_team'];
        $this->model->save();
        return $this->model;
    }

    public function getListByMatchId($matchId)
    {
        return $this->model->where('match_id', $matchId)->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    
    public function update($id, $matchId, array $data)
    {
        $this->model = MatchConfig::where('id', $id)->orderBy('id', 'desc')->get()->first();
        $isDirty = false;
        if($this->model->match_id != $matchId){
            $isDirty = true;
            $this->model->match_id = $matchId;
        }
        foreach($data as $key => $value){
            $isDirty = true;
            $this->model->$key = $value;
        }
        if(!$isDirty){
            throw new InvalidArgumentException('no data to be updated!');
        }
        $this->model->save();
        
        return $this->model;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        $user->delete();
    }
}
