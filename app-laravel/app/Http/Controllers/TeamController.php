<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Repositories\UserRepository;
use App\Http\Requests\TeamRequest;
use App\Repositories\MatchSoccerRepository;
use App\Repositories\TeamRepository;

class TeamController extends Controller
{
    private UserRepository $userRepository;
    private MatchSoccerRepository $matchSoccerRepository;
    private TeamRepository $teamRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->matchSoccerRepository = new MatchSoccerRepository();
        $this->teamRepository = new TeamRepository();
    }

    public function index()
    {
        try{
            $team = $this->teamRepository->all();
            return response()->json($team);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $payload = new TeamRequest($request->all());
            $team = $this->teamRepository->create($payload->query());
            return response()->json($team, 201);
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
            $team = $this->teamRepository->find($id);
            return response()->json($team);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = new teamRequest($request->all());
            $team = $this->teamRepository->update($payload->query(), $id);
            return response()->json($team, 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $this->teamRepository->delete($id);
            return response()->json(['message' => "Time ".$id." excluido com sucesso!"] , 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }
}
