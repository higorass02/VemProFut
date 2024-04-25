<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserGroupRequest;
use App\Repositories\UserGroupRepository;

class UserGroupController extends Controller
{
    private UserGroupRepository $userGroupRepository;

    public function __construct()
    {
        $this->userGroupRepository = new UserGroupRepository();
    }

    public function index()
    {
        try{
            $userGroup = $this->userGroupRepository->all();
            return response()->json($userGroup);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try{
            $payload = new UserGroupRequest($request->all());
            $userGroup = $this->userGroupRepository->create($payload->query());
            return response()->json($userGroup, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function show($id)
    {
        try{
            $userGroup = $this->userGroupRepository->find($id);
            return response()->json($userGroup);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = new UserGroupRequest($request->all());
            $userGroup = $this->userGroupRepository->update($payload->query(), $id);
            return response()->json($userGroup, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function destroy($id)
    {
        try{
            $this->userGroupRepository->delete($id);
            return response()->json(['message' => "vinculo de grupo ".$id." excluido com sucesso!"] , 201);
        }catch(Exception $e){
            dd($e);
        }
    }
}
