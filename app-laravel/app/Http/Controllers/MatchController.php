<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Repositories\UserRepository;
use App\Http\Requests\MatchSoccerRequest;
use App\Repositories\MatchSoccerRepository;

class MatchController extends Controller
{
    private MatchSoccerRepository $matchSoccerRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->matchSoccerRepository = new MatchSoccerRepository();
    }

    public function index()
    {
        try{
            $matchSoccer = $this->matchSoccerRepository->all();
            return response()->json($matchSoccer);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            dd($e);
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $payload = new MatchSoccerRequest($request->all());
            $matchSoccer = $this->matchSoccerRepository->create($payload->query());
            return response()->json($matchSoccer, 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            dd($e);
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function show($id)
    {
        try{
            $matchSoccer = $this->matchSoccerRepository->find($id);
            return response()->json($matchSoccer);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = new MatchSoccerRequest($request->all());
            $matchSoccer = $this->matchSoccerRepository->update($payload->query(), $id);
            return response()->json($matchSoccer, 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            dd($e);
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $this->matchSoccerRepository->delete($id);
            return response()->json(['message' => "partida ".$id." excluida com sucesso!"] , 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }
}
