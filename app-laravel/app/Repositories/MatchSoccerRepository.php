<?php

namespace App\Repositories;

use App\Models\MatchSoccer;
use InvalidArgumentException;

class MatchSoccerRepository
{
    private MatchSoccer $model;
    private UserRepository $userRepository;
    private GroupRepository $groupRepository;

    public function __construct(
        ?MatchSoccer $model = null,
        ?UserRepository $userRepository = null,
        ?GroupRepository $groupRepository = null,
    )
    {
        $this->model = $model ?? new MatchSoccer();
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->groupRepository = $groupRepository ?? new GroupRepository();
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(array $data)
    {
        $this->validUser($data['user_id']);
        $this->model->user_id = $data['user_id'];
        if($data['group_id']){
            $this->validExistGroup($data['group_id']);
            $this->model->group_id = $data['group_id'];
        }
        $this->model->group_id = $data['group_id'];
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

    public function update(array $data, $id)
    {
        $this->model = MatchSoccer::where('id', $id)->get()->first();
        $isDirty = false;
        foreach($data as $key => $value){
            if($this->model->$key != $value){
                $isDirty = true;
                if($key == 'status'){
                    $this->validationStatus($value);
                }
                if($key == 'group_id'){
                    $this->validExistGroup($data['group_id']);
                }
            }
            $this->model->$key = $value;
        }
        
        if($isDirty){
            $this->model->update();
        }
        
        return $this->model;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        $user->delete();
    }
    public function validUser($user_id)
    {
        if(!$this->userRepository->find($user_id)){
            throw new InvalidArgumentException('User Not Found!');
        }
    }
    public function validExistGroup($group_id)
    {
        if(!$this->groupRepository->find($group_id)){
            throw new InvalidArgumentException('Group Not Found!');
        }
    }
    private function validationStatus($status)
    {
        if(!in_array($status, $this->model->getStatus())){
            throw new InvalidArgumentException("Status Invalido");
        }
    }
}
