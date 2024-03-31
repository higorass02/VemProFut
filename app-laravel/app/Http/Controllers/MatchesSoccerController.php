<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\MatchSoccerRequest;
use App\Repositories\MatchSoccerRepository;

class MatchesSoccerController extends Controller
{
    private MatchSoccerRepository $matchSoccerRepository;

    public function __construct()
    {
        $this->matchSoccerRepository = new MatchSoccerRepository();
    }

    public function index()
    {
        try{
            $matchSoccer = $this->matchSoccerRepository->all();
            return response()->json($matchSoccer);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try{
            $payload = new MatchSoccerRequest($request->all());
            $matchSoccer = $this->matchSoccerRepository->create($payload->query());
            return response()->json($matchSoccer, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function show($id)
    {
        try{
            $matchSoccer = $this->matchSoccerRepository->find($id);
            return response()->json($matchSoccer);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = new MatchSoccerRequest($request->all());
            $matchSoccer = $this->matchSoccerRepository->update($payload->query(), $id);
            return response()->json($matchSoccer, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function destroy($id)
    {
        try{
            $this->matchSoccerRepository->delete($id);
            return response()->json(['message' => "partida ".$id." excluida com sucesso!"] , 201);
        }catch(Exception $e){
            dd($e);
        }
    }
}
