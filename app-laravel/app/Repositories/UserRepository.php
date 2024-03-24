<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(?User $user = null)
    {
        $this->user = $user ?? new User();
    }

    public function all()
    {
        return $this->user->all();
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function update(array $data, $id)
    {
        $user = $this->user->find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();
    }
}
