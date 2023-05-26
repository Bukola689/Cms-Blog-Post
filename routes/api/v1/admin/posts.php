<?php

use App\Http\Controllers\V1\Admin\PostController;

//use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/count-posts', [PostController::class, 'getTotalPost']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::DELETE('/posts/{post}', [PostController::class, 'destroy']);
    Route::get('/posts/{search}', [PostController::class, 'searchPost']);   
 