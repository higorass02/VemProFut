<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class UserGroupRepository
{
    protected UserGroup $model;
    protected GroupRepository $groupRepository;
    protected UserRepository $userRepository;
    

    public function __construct(
        ?UserGroup $model = null,
        ?GroupRepository $groupRepository = null,
        ?UserRepository $userRepository = null
        )
    {
        $this->model = $model ?? new UserGroup();
        $this->groupRepository = $groupRepository ?? new GroupRepository();
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        $this->validGroupAndUserExist($data);
        $this->model->user_id = $data['user_id'];
        $this->model->group_id = $data['group_id'];
        $this->model->save();
        return $this->model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(array $data, $id)
    {
        $this->validGroupAndUserExist($data);
        $this->model = UserGroup::where('id', $id)->get()->first();
        $isDirty = false;
        foreach($data as $key => $value){
            if($this->model->$key != $value){
                $isDirty = true;
                $this->model->$key = $value;
            }
        }
        if(!$isDirty){
            throw new InvalidArgumentException('no data to be updated!');
        }
        $this->model->update();
        return $this->model;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        $user->delete();
    }
    public function validGroupAndUserExist($data)
    {
        if(is_null($this->groupRepository->find($data['group_id']))){
            throw new InvalidArgumentException('Group not found!');
        }
        if(is_null($this->userRepository->find($data['user_id']))){
            throw new InvalidArgumentException('User not found!');
        }
    }

    public function getUsers($groupId)
    {
        $users = $this->model::where('group_id', $groupId)->get();
        $usersColletion = new Collection();
        foreach ($users as $key => $user) {
            $usersColletion->push($user->user);
        }
        return $usersColletion;
    }
}
