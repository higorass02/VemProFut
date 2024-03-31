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
        $this->user->nome = $data['nome'];
        $this->user->email = $data['email'];
        $this->user->sexo = $data['sexo'];
        $this->user->celular = $data['celular'];
        $this->user->apelido = $data['apelido'];
        $this->user->password = $data['password'];
        $this->user->papel = $data['papel'];
        $this->user->dt_nasc = new Carbon($data['dt_nasc']);
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
            if($key == 'dt_nasc'){
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
