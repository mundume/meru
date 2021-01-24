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
        Route::post('/agent_lock/{id}', [dashboardcontroller::class, 'agent_lock'])->name('dashboard.agent_lock');
        Route::post('/agent_unlock/{id}', [dashboardcontroller::class, 'agent_unlock'])->name('dashboard.agent_unlock');
        Route::post('/top_up_agent', [dashboardcontroller::class, 'top_up_agent'])->name('dashboard.topup_agent');
    });
    Route::prefix('fleets')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'fleets'])->name('dashboard.fleets');
        Route::post('/add_fleet', [dashboardcontroller::class, 'add_fleet'])->name('dashboard.add_fleet');
        Route::post('/unsuspend_fleet/{id}', [dashboardcontroller::class, 'unsuspend_fleet'])->name('dashboard.unsuspend_fleet');
        Route::post('/suspend_fleet/{id}', [dashboardcontroller::class, 'suspend_fleet'])->name('dashboard.suspend_fleet');
        Route::post('/edit_fleet/{id}', [dashboardcontroller::class, 'edit_fleet'])->name('dashboard.edit_fleet');
        Route::post('/delete_fleet/{id}', [dashboardcontroller::class, 'delete_fleet'])->name('dashboard.delete_fleet');
    });
    Route::prefix('calendarial')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'calendarial'])->name('dashboard.calendarial');
        Route::post('/add_peak', [dashboardcontroller::class, 'add_peak'])->name('dashboard.add_peak');
    });
    Route::prefix('routes')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'routes'])->name('dashboard.routes');
        Route::get('/add', [dashboardcontroller::class, 'add_route'])->name('dashboard.add_route');
        Route::post('/add/new', [dashboardcontroller::class, 'create_route'])->name('dashboard.create_route');
        Route::get('/edit/{id}', [dashboardcontroller::class, 'edit_route'])->name('dashboard.edit_route');
        Route::post('/edit/existing/{id}', [dashboardcontroller::class, 'edit_route_post'])->name('dashboard.edit_route_post');
        Route::post('/delete_route/{id}', [dashboardcontroller::class, 'delete_route'])->name('dashboard.delete_route');
        Route::post('/suspend_route/{id}', [dashboardcontroller::class, 'suspend_route'])->name('dashboard.suspend_route');
        Route::post('/unsuspend_route/{id}', [dashboardcontroller::class, 'unsuspend_route'])->name('dashboard.unsuspend_route');
    });
});
Route::get('/route/{id}', [pagescontroller::class, 'show_route'])->name('route.show');
