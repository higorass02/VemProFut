<?php

namespace App\Repositories;
use App\Models\Group;
class GroupRepository
{
    protected $group;

    public function __construct(?Group $group = null)
    {
        $this->group = $group ?? new Group();
    }

    public function all()
    {
        return $this->group->all();
    }

    public function create(array $data)
    {
        $this->group->status = Group::STATUS_ENABLED;
        $this->group->alias = $data['alias'];
        $this->group->user_id = $data['user_id'];
        $this->group->save();
        return $this->group;
    }

    public function find($id)
    {
        return $this->group->find($id);
    }

    public function update(array $data, $id)
    {
        $this->group = Group::where('id', $id)->get()->first();
        foreach($data as $key => $value){
            $this->group->$key = $value;
        }
        $this->group->save();
        return $this->group;
    }

    public function delete($id)
    {
        $user = $this->group->find($id);
        $user->delete();
    }
}
