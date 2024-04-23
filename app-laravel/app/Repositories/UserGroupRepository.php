<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\UserGroup;
class UserGroupRepository
{
    protected $userGroup;

    public function __construct(?UserGroup $userGroup = null)
    {
        $this->userGroup = $userGroup ?? new UserGroup();
    }

    public function all()
    {
        return $this->userGroup->all();
    }

    public function create(array $data)
    {
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
        $this->userGroup = UserGroup::where('id', $id)->get()->first();
        foreach($data as $key => $value){
            $this->userGroup->$key = $value;
        }
        $this->userGroup->save();
        return $this->userGroup;
    }

    public function delete($id)
    {
        $user = $this->userGroup->find($id);
        $user->delete();
    }
}
