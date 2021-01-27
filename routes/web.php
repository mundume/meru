<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pagescontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\agentscontroller;
use App\Http\Controllers\pesacontroller;
use App\Http\Controllers\parcelscontroller;
use App\Http\Controllers\settingscontroller;

Auth::routes();
Route::get('/', [pagescontroller::class, 'independent'])->name('independent');
Route::prefix('dashboard')->group(function() {
    Route::get('/', [dashboardcontroller::class, 'index'])->name('dashboard.index');
    Route::get('/bookings', [dashboardcontroller::class, 'bookings'])->name('dashboard.bookings');
    Route::post('/bookings/search', [dashboardcontroller::class, 'filter_bookings'])->name('dashboard.filter_booking');
    Route::prefix('agents')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'agents'])->name('dashboard.agents');
        Route::post('/add_agent', [dashboardcontroller::class, 'add_agent'])->name('dashboard.add_agent');
        Route::post('/agent_lock/{id}', [dashboardcontroller::class, 'agent_lock'])->name('dashboard.agent_lock');
        Route::post('/agent_unlock/{id}', [dashboardcontroller::class, 'agent_unlock'])->name('dashboard.agent_unlock');
        Route::post('/top_up_agent', [dashboardcontroller::class, 'top_up_agent'])->name('dashboard.topup_agent');
    });
    Route::prefix('fleets')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'add_fleets'])->name('dashboard.add_fleets');
        Route::post('/add_fleet', [dashboardcontroller::class, 'add_fleet'])->name('dashboard.add_fleet');
        Route::post('/unsuspend_fleet/{id}', [dashboardcontroller::class, 'unsuspend_fleet'])->name('dashboard.unsuspend_fleet');
        Route::post('/suspend_fleet/{id}', [dashboardcontroller::class, 'suspend_fleet'])->name('dashboard.suspend_fleet');
        Route::post('/edit_fleet/{id}', [dashboardcontroller::class, 'edit_fleet'])->name('dashboard.edit_fleet');
        Route::post('/delete_fleet/{id}', [dashboardcontroller::class, 'delete_fleet'])->name('dashboard.delete_fleet');
        Route::post('/dispatch/{user_id}/{fleet_unique}', [dashboardcontroller::class, 'dispatch_fleet'])->name('dashboard.dispatch_fleet');        
    });
    Route::prefix('calendarial')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'calendarial'])->name('dashboard.calendarial');
        Route::post('/add_peak', [dashboardcontroller::class, 'add_peak'])->name('dashboard.add_peak');
        Route::post('/edit_peak/{id}', [dashboardcontroller::class, 'edit_peak'])->name('dashboard.edit_peak');
        Route::post('/delete_peak/{id}', [dashboardcontroller::class, 'delete_peak'])->name('dashboard.delete_peak');
    });
    Route::prefix('routes')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'routes'])->name('dashboard.routes');
        Route::get('/add', [dashboardcontroller::class, 'add_route'])->name('dashboard.add_route');
        Route::post('/add/new', [dashboardcontroller::class, 'create_route'])->name('dashboard.create_route');
        Route::get('/edit/{id}', [dashboardcontroller::class, 'edit_route'])->name('dashboard.edit_route');
        Route::post('/edit/existing/{id}', [dashboardcontroller::class, 'edit_route_post'])->name('dashboard.edit_route_post');
        Route::post('/delete_route/{id}', [dashboardcontroller::class, 'delete_route'])->name('dashboard.delete_route');
        Route::post('/suspend/{id}', [dashboardcontroller::class, 'suspend_route'])->name('dashboard.suspend_route');
        Route::post('/unsuspend/{id}', [dashboardcontroller::class, 'unsuspend_route'])->name('dashboard.unsuspend_route');
        Route::post('/admin/suspend/{id}', [dashboardcontroller::class, 'admin_suspend_route'])->name('dashboard.admin_suspend_route');
        Route::post('/admin/unsuspend/{id}', [dashboardcontroller::class, 'admin_unsuspend_route'])->name('dashboard.admin_unsuspend_route');
    });
    Route::prefix('books')->group(function() {
        Route::post('/booking_office', [dashboardcontroller::class, 'booking_office'])->name('dashboard.booking_office');
    });
    Route::prefix('parcels')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'parcels'])->name('dashboard.parcels');
        Route::get('/create', [parcelscontroller::class, 'index'])->name('dashboard.add_parcel');
        Route::post('/create/post', [parcelscontroller::class, 'post_parcel'])->name('dashboard.post_parcel');
    });
    Route::prefix('wallet')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'wallet'])->name('dashboard.wallet');
        Route::post('/wallet/search', [dashboardcontroller::class, 'filter_wallet'])->name('dashboard.filter_wallet');
    });
    Route::get('/account', [dashboardcontroller::class, 'edit_account'])->name('dashboard.edit_account');
    Route::post('/account/edit/{id}', [dashboardcontroller::class, 'update_account'])->name('dashboard.update_account');
    Route::post('/booked/seats', [dashboardcontroller::class, 'booked'])->name('dashboard.booked');
    Route::post('/booked/seats/modal', [dashboardcontroller::class, 'modal_booked'])->name('dashboard.get_booked_seats');
    Route::post('/moderator/create/ticket', [dashboardcontroller::class, 'moderator_sell_ticket'])->name('dashboard.moderator_sell_ticket');
    Route::post('/commuter/delay/{id}', [dashboardcontroller::class, 'delay_commuter'])->name('dashboard.delay_commuter');
    Route::post('/commuter/activate/{id}', [dashboardcontroller::class, 'activate_commuter'])->name('dashboard.activate_commuter');
    Route::prefix('print')->group(function() {
        Route::post('/dispatch/{fleet_unique}', [dashboardcontroller::class, 'dispatch_fleet_print'])->name('dashboard.dispatch_fleet_print');
        Route::post('/dropoff', [parcelscontroller::class, 'print_dropoff'])->name('dashboard.print_dropoff');
    });
    Route::get('/dispatches', [dashboardcontroller::class, 'dispatches'])->name('dashboard.dispatches');
    Route::post('/dispatches/search', [dashboardcontroller::class, 'search_dispatches'])->name('dashboard.search_dispatches');
    Route::post('/balance', [dashboardcontroller::class, 'fetch_balance'])->name('dashboard.fetch_balance');
    Route::prefix('settings')->group(function() {
        Route::get('/', [settingscontroller::class, 'index'])->name('dashboard.settings');
        Route::post('/add_provider', [settingscontroller::class, 'add_provider'])->name('dashboard.add_provider');
        Route::post('/add_dropoff', [settingscontroller::class, 'add_dropoff'])->name('dashboard.add_dropoff');
        Route::post('/add_coordinate', [settingscontroller::class, 'add_coordinate'])->name('dashboard.add_coordinate');
        Route::post('/delete_charge/{id}', [settingscontroller::class, 'delete_charge'])->name('dashboard.delete_charge');
        Route::post('/add_charge', [settingscontroller::class, 'add_charge'])->name('dashboard.add_charge');
        Route::post('/edit_charge', [settingscontroller::class, 'edit_charge'])->name('dashboard.edit_charge');
        Route::get('/preview', [settingscontroller::class, 'preview'])->name('dashboard.preview');
    });
});
Route::get('/route/{id}', [pagescontroller::class, 'show_route'])->name('route.show');

Route::get('/book/tickets/7/{id}', [dashboardcontroller::class, 'view_ticket_7'])->name('dashboard.view_ticket_7');
Route::get('/book/tickets/10/{id}', [dashboardcontroller::class, 'view_ticket_10'])->name('dashboard.view_ticket_10');
Route::get('/book/tickets/11/{id}', [dashboardcontroller::class, 'view_ticket_11'])->name('dashboard.view_ticket_11');
Route::get('/book/tickets/14/{id}', [dashboardcontroller::class, 'view_ticket_14'])->name('dashboard.view_ticket_14');
Route::get('/book/tickets/16/{id}', [dashboardcontroller::class, 'view_ticket_16'])->name('dashboard.view_ticket_16');
