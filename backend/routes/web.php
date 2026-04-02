<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViagensController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('viagens', ViagensController::class);
    Route::patch('viagens/{id}/status', [ViagensController::class, 'updateStatus'])->name('viagens.status');
    
    
});






