<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Repositories\GroupRepository;

class GroupController extends Controller
{
    private GroupRepository $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
    }

    public function index()
    {
        try{
            $groups = $this->groupRepository->all();
            return response()->json($groups);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try{
            $payload = new GroupRequest($request->all());
            $groups = $this->groupRepository->create($payload->query());
            return response()->json($groups, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function show($id)
    {
        try{
            $groups = $this->groupRepository->find($id);
            return response()->json($groups);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = new GroupRequest($request->all());
            $groups = $this->groupRepository->update($payload->query(), $id);
            return response()->json($groups, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function destroy($id)
    {
        try{
            $this->groupRepository->delete($id);
            return response()->json(['message' => "Grupo ".$id." excluido com sucesso!"] , 201);
        }catch(Exception $e){
            dd($e);
        }
    }
}
