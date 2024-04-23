<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\MatchConfigController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/team', TeamController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/group', GroupController::class);
Route::apiResource('/match', MatchController::class);
Route::apiResource('/user/group', UserGroupController::class);
Route::apiResource('/match/{matchId}/config', MatchConfigController::class);
