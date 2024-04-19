<?php

namespace App\Repositories;

use App\Models\MatchSoccer;

class MatchSoccerRepository
{
    private MatchSoccer $model;

    public function __construct(?MatchSoccer $model = null)
    {
        $this->model = $model ?? new MatchSoccer();
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(array $data)
    {
        $this->model->user_id = $data['user_id'];
        $this->model->status = MatchSoccer::STATUS_CREATED;
        $this->model->save();
        return $this->model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getListByIdMatch($matchId)
    {
        return $this->model->where('match_id',$matchId)->get();
    }

    private function validationChangeStatus($status)
    {
        if($this->model->status != $status){
            if(in_array($status, $this->model->getStatus())){
                return true;
            }
        }
        return false;
    }
    public function update(array $data, $id)
    {
        $this->model = MatchSoccer::where('id', $id)->get()->first();
        $validationStatus = $this->validationChangeStatus($data['status']);
        if($validationStatus){
            $this->model->status = $data['status'];
            $this->model->save();
        }
        return $this->model;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        $user->delete();
    }
}
