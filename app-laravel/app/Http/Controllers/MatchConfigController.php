<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Http\Requests\MatchConfigRequest;
use App\Repositories\MatchSoccerRepository;
use App\Repositories\MatchConfigRepository;

class MatchConfigController extends Controller
{
    private MatchSoccerRepository $matchSoccerRepository;
    private MatchConfigRepository $matchConfigRepository;

    public function __construct()
    {
        $this->matchSoccerRepository = new MatchSoccerRepository();
        $this->matchConfigRepository = new MatchConfigRepository();
    }

    public function index($matchId)
    {
        try{
            $matchConfig = $this->matchConfigRepository->getListByMatchId($matchId);
            return response()->json($matchConfig);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            dd($e);
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function store(Request $request, $matchId)
    {
        try{
            $payload = new MatchConfigRequest($request->all());
            $this->matchExistValidator($matchId);
            $matchConfig = $this->matchConfigRepository->create($matchId, $payload->query());
            return response()->json($matchConfig, 201);
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
            $matchConfig = $this->matchConfigRepository->find($id);
            return response()->json($matchConfig);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function update(Request $request, $id, $matchId)
    {
        try{
            $payload = new MatchConfigRequest($request->all());
            $matchConfig = $this->matchConfigRepository->update($id, $matchId, $payload->query());
            return response()->json($matchConfig, 201);
        }catch(\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e) {
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $this->matchConfigRepository->delete($id);
            return response()->json(['message' => "Time ".$id." excluido com sucesso!"] , 201);
        }catch(\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e) {
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function matchExistValidator($matchId)
    {
        if(is_null($this->matchSoccerRepository->find($matchId))) {
            throw new InvalidArgumentException('Match Not Found!');
        }
    }
}
