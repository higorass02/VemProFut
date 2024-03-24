<?php

use App\Http\Controllers\Site\CustomerController;
use App\Http\Controllers\Site\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->group( function () {
    Route::prefix('/employee')->group( function () {
        Route::get('', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });
    Route::prefix('/customer')->group( function () {
        Route::get('', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });
});
