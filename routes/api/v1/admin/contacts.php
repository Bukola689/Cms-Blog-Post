<?php

use App\Http\Controllers\V1\Admin\AdminContactController;
use Illuminate\Support\Facades\Route;

Route::get('/contacts', [AdminContactController::class, 'index']);
Route::get('/count-contacts', [AdminContactController::class, 'getTotalContact']);
Route::DELETE('/contacts/{contact}', [AdminContactController::class, 'destroy']);

