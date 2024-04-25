<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\UserGroup;
use InvalidArgumentException;

class UserGroupRepository
{
    protected $userGroup;
    protected GroupRepository $groupRepository;
    protected UserRepository $userRepository;
    

    public function __construct(
        ?UserGroup $userGroup = null,
        ?GroupRepository $groupRepository = null,
        ?UserRepository $userRepository = null
        )
    {
        $this->userGroup = $userGroup ?? new UserGroup();
        $this->groupRepository = $groupRepository ?? new GroupRepository();
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    public function all()
    {
        return $this->userGroup->all();
    }

    public function create(array $data)
    {
        $this->validGroupAndUserExist($data);
        $this->userGroup->user_id = $data['user_id'];
        $this->userGroup->group_id = $data['group_id'];
        $this->userGroup->save();
        return $this->userGroup;
    }

    public function find($id)
    {
        return $this->userGroup->find($id);
    }

    public function update(array $data, $id)
    {
        $this->validGroupAndUserExist($data);
        $this->userGroup = UserGroup::where('id', $id)->get()->first();
        $isDirty = false;
        foreach($data as $key => $value){
            if($this->userGroup->$key != $value){
                $isDirty = true;
                $this->userGroup->$key = $value;
            }
        }
        if(!$isDirty){
            throw new InvalidArgumentException('no data to be updated!');
        }
        $this->userGroup->update();
        return $this->userGroup;
    }

    public function delete($id)
    {
        $user = $this->userGroup->find($id);
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
}
