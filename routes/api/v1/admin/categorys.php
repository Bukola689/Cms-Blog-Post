<?php

use App\Http\Controllers\V1\Admin\CategoryController;

use Illuminate\Support\Facades\Route;


        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/count-categories', [CategoryController::class, 'getTotalCategory']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::get('/categories/{category}', [CategoryController::class, 'show']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::DELETE('/categories/{category}', [CategoryController::class, 'destroy']);
        Route::get('/categories/{search}', [categoryController::class, 'searchCategory']);

