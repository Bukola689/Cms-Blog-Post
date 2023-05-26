<?php

use App\Http\Controllers\V1\Admin\TagController;

//use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;

    Route::get('/tags', [TagController::class, 'index']);
        Route::get('/count-tags', [TagController::class, 'getTotalTag']);
        Route::post('/tags', [TagController::class, 'store']);
        Route::get('/tags/{tag}', [TagController::class, 'show']);
        Route::put('/tags/{tag}', [TagController::class, 'update']);
        Route::DELETE('/tags/{tag}', [TagController::class, 'destroy']);
        Route::get('/tags/{search}', [TagController::class, 'searchTag']);
