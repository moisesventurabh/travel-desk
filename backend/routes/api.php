<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViagensController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/viagens', [ViagensController::class, 'index']);
    Route::post('/viagens', [ViagensController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/viagens/{id}', [ViagensController::class, 'destroy']);
});