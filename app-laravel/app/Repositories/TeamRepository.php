<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository
{
    private Team $model;

    public function __construct(?Team $model = null)
    {
        $this->model = $model ?? new Team();
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(array $data)
    {
        $this->userMatchValidation($data);
        $this->model->user_id = $data['user_id'];
        $this->model->match_id = $data['match_id'];
        $this->model->status = Team::STATUS_ENABLED;
        $this->model->save();
        return $this->model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(array $data, $id)
    {
        $this->model = Team::find($id);
        $this->validationExist();
        $this->validationChangeStatus($data['status']);
        $this->model->status = $data['status'];
        
        $this->model->save();

        return $this->model;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        $user->delete();
    }

    public function userMatchValidation(array $data)
    {
        $teams = $this->model->where('user_id', $data['user_id'])
                    ->where('match_id', $data['match_id'])
                    ->get();

        foreach($teams as $team){
            
        }
        // if($validation){
        //     throw new \InvalidArgumentException('O Jogador já está dentro desta partida!');
        // }
    }

    private function validationChangeStatus(int $status)
    {
        if($this->model->status == $status){
            if(!in_array($status, $this->model->getStatus())){
                throw new \InvalidArgumentException('Status Invalido!');
            }
            throw new \InvalidArgumentException('Status não foi alterado!');
        }
    }
    private function validationExist()
    {
        if(is_null($this->model)){
            throw new \InvalidArgumentException("Jogador ainda não convocado para este Time");
        }
    }
}
