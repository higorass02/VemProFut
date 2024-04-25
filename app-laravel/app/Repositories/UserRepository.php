<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;

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
        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        $this->user->gender = $data['gender'];
        $this->user->phone = $data['phone'];
        $this->user->alias = $data['alias'];
        $this->user->password = $data['password'];
        $this->user->id_role = $data['id_role'];
        $this->user->dt_birthdate = new Carbon($data['dt_birthdate']);
        $this->user->save();
        return $this->user;
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function update(array $data, $id)
    {
        $this->user = User::where('id', $id)->get()->first();
        foreach($data as $key => $value){
            if($key == 'dt_birthdate'){
                $value = new Carbon($value);
            }
            $this->user->$key = $value;
        }
        $this->user->save();
        return $this->user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();
    }
}
