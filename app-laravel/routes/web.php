<?php

use App\Http\Controllers\Site\CustomerController;
use App\Http\Controllers\Site\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
