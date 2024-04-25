<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository
{
    private Team $model;
    private UserRepository $userRepository;
    private MatchSoccerRepository $matchRepository;

    public function __construct(
        ?Team $model = null,
        ?UserRepository $userRepository = null,
        ?MatchSoccerRepository $matchRepository = null
    )
    {
        $this->model = $model ?? new Team();
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->matchRepository = $matchRepository ?? new MatchSoccerRepository();
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(array $data)
    {
        $this->userValidation($data);
        $this->matchValidation($data);
        //buscar usuario do grupo

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

    public function userValidation($userId)
    {
        if(!$this->userRepository->find($userId)){
            throw new \InvalidArgumentException('User not Found!');
        }
    }
    
    public function matchValidation($matchId)
    {
        $match = $this->matchRepository->find($matchId)[0];
        if(!$match){
            throw new \InvalidArgumentException('Match not Found!');
        }
        if(!$match->config){
            throw new \InvalidArgumentException('Match config not Found!');
        }
    }
}
