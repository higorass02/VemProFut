<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use DateTime;
use Exception;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $payload = $request->all();
        try{
            $user = new User();
            foreach($payload as $key => $value){
                if('dt_nasc' == $key){
                    $value = new Carbon($value);
                }
                $user->$key = $value;
            }
            $user->save();
            return response()->json($user, 201);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
