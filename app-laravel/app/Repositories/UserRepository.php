<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use InvalidArgumentException;

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
        $this->validGender($data['gender']);
        $this->validRole($data['role']);

        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        $this->user->gender = $data['gender'];
        $this->user->phone = $data['phone'];
        $this->user->alias = $data['alias'];
        $this->user->password = $data['password'];
        $this->user->role = $data['role'];
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
        $isDirty = false;
        foreach($data as $key => $value){
            if($this->user->$key != $value){
                $isDirty = true;
                if($key == 'dt_birthdate'){
                    $value = new Carbon($value);
                }
                if($key == 'gender'){
                    $this->validGender($data['gender']);
                }
                if($key == 'role'){
                    $this->validRole($data['role']);
                }
                $this->user->$key = $value;
            }
        }
        if(!$isDirty){
            throw new InvalidArgumentException('no data to be updated!');
        }
        $this->user->save();
        return $this->user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();
    }
    
    public function validGender($gender)
    {
        $exp = $gender == $this->user::SEXO_FEMININO || $gender == $this->user::SEXO_MASCULINO || $gender == $this->user::ROLE_JOGADOR_ADMIN;
        if(!$exp){
            throw new InvalidArgumentException('Gender invalid!');
        }
    }

    public function validRole($role)
    {
        $exp = $role == $this->user::ROLE_ADMIN_SYSTEM || $role == $this->user::ROLE_JOGADOR_ADMIN || $role == $this->user::ROLE_JOGADOR;
        if(!$exp){
            throw new InvalidArgumentException('Role invalid!');
        }
    }
}
