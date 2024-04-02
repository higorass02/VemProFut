<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MatchesSoccerController;
use App\Http\Controllers\UsersMatchesSoccerController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/users', UserController::class);
Route::apiResource('/matches-soccer', MatchesSoccerController::class);
Route::apiResource('/users_matches', UsersMatchesSoccerController::class);
