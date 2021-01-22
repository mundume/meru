<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pagescontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\agentscontroller;
use App\Http\Controllers\pesacontroller;

Auth::routes();
Route::get('/', [pagescontroller::class, 'independent'])->name('independent');
Route::prefix('dashboard')->group(function() {
    Route::get('/', [dashboardcontroller::class, 'index'])->name('dashboard.index');
    Route::prefix('agents')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'agents'])->name('dashboard.agents');
        Route::post('/add_agent', [dashboardcontroller::class, 'add_agent'])->name('dashboard.add_agent');
    });
});
