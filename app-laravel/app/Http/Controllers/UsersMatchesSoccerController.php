<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Repositories\UserRepository;
use App\Http\Requests\UsersMatchesRequest;
use App\Repositories\MatchSoccerRepository;
use App\Repositories\UsersMatchesRepository;

class UsersMatchesSoccerController extends Controller
{
    private UserRepository $userRepository;
    private MatchSoccerRepository $matchSoccerRepository;
    private UsersMatchesRepository $usersMatchesRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->matchSoccerRepository = new MatchSoccerRepository();
        $this->usersMatchesRepository = new UsersMatchesRepository();
    }

    public function index()
    {
        try{
            $usersMatches = $this->usersMatchesRepository->all();
            return response()->json($usersMatches);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $payload = new UsersMatchesRequest($request->all());
            $this->existUserAndMatchesValidator($payload['user_id'], $payload['match_id']);
            $usersMatches = $this->usersMatchesRepository->create($payload->query());
            return response()->json($usersMatches, 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function show($id)
    {
        try{
            $usersMatches = $this->usersMatchesRepository->find($id);
            return response()->json($usersMatches);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = new UsersMatchesRequest($request->all());
            $usersMatches = $this->usersMatchesRepository->update($payload->query(), $id);
            return response()->json($usersMatches, 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $this->usersMatchesRepository->delete($id);
            return response()->json(['message' => "Time ".$id." excluido com sucesso!"] , 201);
        }catch(\InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error Critical'], 500);
        }
    }

    public function existUserAndMatchesValidator($user_id, $match_id)
    {
        if(is_null($this->userRepository->find($user_id))){
            throw new InvalidArgumentException('User Not Found!');
        }
        if(is_null($this->matchSoccerRepository->find($match_id))){
            throw new InvalidArgumentException('Match Not Found!');
        }
    }
}
