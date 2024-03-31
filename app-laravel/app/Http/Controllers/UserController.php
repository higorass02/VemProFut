<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function index()
    {
        try{
            $users = $this->userRepository->all();
            return response()->json($users);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try{
            $payload = new UserRequest($request->all());
            $user = $this->userRepository->create($payload->query());
            return response()->json($user, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function show($id)
    {
        try{
            $user = $this->userRepository->find($id);
            return response()->json($user);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = new UserRequest($request->all());
            $user = $this->userRepository->update($payload->query(), $id);
            return response()->json($user, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function destroy($id)
    {
        try{
            $this->userRepository->delete($id);
            return response()->json(['message' => "usuario ".$id." excluido com sucesso!"] , 201);
        }catch(Exception $e){
            dd($e);
        }
    }
}
