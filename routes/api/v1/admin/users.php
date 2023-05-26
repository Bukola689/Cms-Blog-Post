<?php

//namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\V1\Admin\UserController;

use Illuminate\Support\Facades\Route;

   Route::get('/users', [UserController::class, 'index']);
   Route::get('/count-users', [UserController::class, 'getTotalPost']);
   Route::post('/users', [UserController::class, 'store']);
   Route::get('/users/{user}', [UserController::class, 'show']);
   Route::put('/users/{user}', [UserController::class, 'update']);
   Route::DELETE('/users/{user}', [UserController::class, 'destroy']);
   Route::get('/users/{search}', [UserController::class, 'searchUser']); 