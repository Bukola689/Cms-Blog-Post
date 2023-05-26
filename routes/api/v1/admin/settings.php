<?php

use App\Http\Controllers\V1\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [SettingsController::class, 'index']);
Route::post('/settings', [SettingsController::class, 'store']);
Route::get('/settings/{comment}', [SettingsController::class, 'show']);
Route::put('/settings/{setting}', [SettingsController::class, 'update']);
Route::DELETE('/settings/{setting}', [SettingsController::class, 'destroy']);

