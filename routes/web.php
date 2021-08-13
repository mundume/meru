<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pagescontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\agentscontroller;
use App\Http\Controllers\pesacontroller;
use App\Http\Controllers\parcelscontroller;
use App\Http\Controllers\settingscontroller;
use App\Http\Controllers\courierscontroller;
use App\Http\Controllers\graphscontroller;

Auth::routes();

//guest
// Route::get('/', function() {
//     return redirect(route('login'));
// });
Route::get('/', [pagescontroller::class, 'independent'])->name('independent');
Route::get('/services', [pagescontroller::class, 'services'])->name('independent.services');
Route::get('/search', [pagescontroller::class, 'search'])->name('independent.search');
Route::post('/step_one/{route_id}', [pagescontroller::class, 'booking_step_one'])->name('independent.booking_step_one');
Route::post('/send/message', [pagescontroller::class, 'send_message'])->name('send_message');
Route::prefix('route')->group(function() {
    Route::get('/booking/{id}', [pagescontroller::class, 'show_route'])->name('route.show');
    Route::get('/booking/complete/{ticket_no}', [pagescontroller::class, 'complete_booking'])->name('independent.complete_booking');
    Route::post('/booking/complete', [pagescontroller::class, 'post_complete_booking'])->name('independent.post_complete_booking');
    Route::get('/booking/status/{ticket_no}', [pagescontroller::class, 'ticket_status'])->name('independent.ticket_status');
    Route::post('/booking/check/status', [pagescontroller::class, 'check_status'])->name('independent.check_status');
});
Route::prefix('payments')->group(function() {
    Route::post('/stk/callback', [pesacontroller::class, 'stk_callback'])->name('payment.callback');
});
// Route::post('/booked/seats', [pagescontroller::class, 'booked_seats'])->name('independent.get_booked_seats');
Route::post('/booked/calendarial', [pagescontroller::class, 'booked_calendarial'])->name('independent.calendarial');
//admin
Route::prefix('dashboard')->group(function() {
    Route::get('/', [dashboardcontroller::class, 'index'])->name('dashboard.index');
    Route::get('/bookings', [dashboardcontroller::class, 'bookings'])->name('dashboard.bookings');
    Route::get('/bookings/future', [dashboardcontroller::class, 'future_bookings'])->name('dashboard.future_bookings');
    Route::get('/bookings/future/{fleet_id}/{travel_date}/{time}', [dashboardcontroller::class, 'future_booking'])->name('dashboard.future_booking');
    Route::post('/bookings/future/check', [dashboardcontroller::class, 'future_bookings_check'])->name('dashboard.future_bookings_check');
    Route::post('/bookings/time', [dashboardcontroller::class, 'look_for_time'])->name('dashboard.look_for_time');
    Route::post('/bookings/search', [dashboardcontroller::class, 'filter_bookings'])->name('dashboard.filter_booking');
    Route::prefix('agents')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'agents'])->name('dashboard.agents');
        Route::post('/add_agent', [dashboardcontroller::class, 'add_agent'])->name('dashboard.add_agent');
        Route::post('/agent_lock/{id}', [dashboardcontroller::class, 'agent_lock'])->name('dashboard.agent_lock');
        Route::post('/agent_unlock/{id}', [dashboardcontroller::class, 'agent_unlock'])->name('dashboard.agent_unlock');
        Route::post('/top_up_agent', [dashboardcontroller::class, 'top_up_agent'])->name('dashboard.topup_agent');
        Route::post('/edit_user/{id}', [dashboardcontroller::class, 'edit_user'])->name('dashboard.edit_user');
    });
    Route::prefix('fleets')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'add_fleets'])->name('dashboard.add_fleets');
        Route::post('/add_fleet', [dashboardcontroller::class, 'add_fleet'])->name('dashboard.add_fleet');
        Route::post('/unsuspend_fleet/{id}', [dashboardcontroller::class, 'unsuspend_fleet'])->name('dashboard.unsuspend_fleet');
        Route::post('/suspend_fleet/{id}', [dashboardcontroller::class, 'suspend_fleet'])->name('dashboard.suspend_fleet');
        Route::post('/edit_fleet/{id}', [dashboardcontroller::class, 'edit_fleet'])->name('dashboard.edit_fleet');
        Route::post('/delete_fleet/{id}', [dashboardcontroller::class, 'delete_fleet'])->name('dashboard.delete_fleet');
        Route::post('/dispatch/{user_id}/{fleet_unique}', [dashboardcontroller::class, 'dispatch_fleet'])->name('dashboard.dispatch_fleet');        
        Route::post('/dispatch/{id}/{route}/{date}', [dashboardcontroller::class, 'dispatch_fleet_future'])->name('dashboard.dispatch_fleet_future');        
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
        Route::get('/all', [dashboardcontroller::class, 'agent_parcels'])->name('dashboard.agent_parcels');
        Route::get('/create', [parcelscontroller::class, 'index'])->name('dashboard.add_parcel');
        Route::post('/create/post', [parcelscontroller::class, 'post_parcel'])->name('dashboard.post_parcel');
        Route::post('/dropoffs/sub_category', [parcelscontroller::class, 'dropoffs_sub_category'])->name('dashboard.dropoffs_sub_category');
        Route::post('/dropoffs/bun_sub_category', [parcelscontroller::class, 'bun_sub_category'])->name('dashboard.bun_sub_category');
        Route::post('/progress/{id}', [parcelscontroller::class, 'update_progress'])->name('dashboard.progress');
        Route::post('/parcel/assign/fleet/{parcel_no}', [parcelscontroller::class, 'parcel_assign_fleet'])->name('dashboard.parcel_assign_fleet');
        Route::post('/picked/{id}', [parcelscontroller::class, 'picked'])->name('dashboard.picked');
        Route::post('/sms/{id}', [parcelscontroller::class, 'parcel_sms'])->name('dashboard.sms');
        Route::post('/agent/bulk/sms', [parcelscontroller::class, 'agent_bulk_sms'])->name('dashboard.agent_bulk_sms');
    });
    Route::prefix('wallet')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'wallet'])->name('dashboard.wallet');
        Route::post('/wallet/search', [dashboardcontroller::class, 'filter_wallet'])->name('dashboard.filter_wallet');
    });
    Route::get('/account', [dashboardcontroller::class, 'edit_account'])->name('dashboard.edit_account');
    Route::post('/account/edit/{id}', [dashboardcontroller::class, 'update_account'])->name('dashboard.update_account');
    Route::post('/booked/seats', [pagescontroller::class, 'booked_seats'])->name('dashboard.booked');
    Route::post('/booked/seats/future', [pagescontroller::class, 'booked_future'])->name('dashboard.booked_future');
    Route::post('/booked/seats/modal', [pagescontroller::class, 'modal_booked'])->name('dashboard.get_booked_seats');
    Route::post('/moderator/create/ticket', [dashboardcontroller::class, 'moderator_sell_ticket'])->name('dashboard.moderator_sell_ticket');
    Route::post('/commuter/delay/{id}', [dashboardcontroller::class, 'delay_commuter'])->name('dashboard.delay_commuter');
    Route::post('/commuter/activate/{id}', [dashboardcontroller::class, 'activate_commuter'])->name('dashboard.activate_commuter');
    Route::prefix('print')->group(function() {
        Route::post('/dispatch/{fleet_unique}', [dashboardcontroller::class, 'dispatch_fleet_print'])->name('dashboard.dispatch_fleet_print');
        Route::post('/dropoff', [parcelscontroller::class, 'print_dropoff'])->name('dashboard.print_dropoff');
        Route::post('/print/parcel/{parcel_no}', [parcelscontroller::class, 'print_parcel'])->name('dashboard.print_parcel');
        Route::post('/print/receipt/{parcel_no}', [parcelscontroller::class, 'print_receipt'])->name('dashboard.print_receipt');
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
    //agent dashboard
    Route::prefix('home')->group(function() {
        Route::get('/', [agentscontroller::class, 'index'])->name('agent.home');
        Route::get('/bookings', [agentscontroller::class, 'bookings'])->name('agent.bookings');
        Route::post('/bookings/search', [agentscontroller::class, 'filter_bookings'])->name('agent.filter_booking');
    });
    //courier dashboard
    Route::prefix('courier')->group(function() {
        Route::get('/', [courierscontroller::class, 'index'])->name('courier.home');
    });
    Route::prefix('sms')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'sms_blasts'])->name('dashboard.sms_blasts');
        Route::post('/add', [dashboardcontroller::class, 'add_customer'])->name('dashboard.add_customer');
        Route::post('/customer/trash/{id}', [dashboardcontroller::class, 'trash_customer'])->name('dashboard.trash_customer');
        Route::post('/customer/trash/all/{id}', [dashboardcontroller::class, 'contacts_delete'])->name('dashboard.contacts_delete');
        Route::post('/import/contacts/{id}', [dashboardcontroller::class, 'import_contacts'])->name('dashboard.import_contacts');
        Route::post('/blasts', [dashboardcontroller::class, 'send_blast_sms'])->name('dashboard.send_blast_sms');
    });
    Route::prefix('graphs')->group(function() {
        Route::get('/sales', [graphscontroller::class, 'sales'])->name('graphs.sales');
        Route::get('/pie_chart', [graphscontroller::class, 'pie_chart'])->name('graphs.pie_chart');
        Route::get('/line_graph', [graphscontroller::class, 'line_graph'])->name('graphs.line_graph');
        Route::get('/reporting_parcel', [graphscontroller::class, 'reporting_parcel'])->name('graphs.reporting_parcel');
        Route::get('/reporting_booking', [graphscontroller::class, 'reporting_booking'])->name('graphs.reporting_booking');
    });
    Route::prefix('reports')->group(function() {
        Route::get('/', [dashboardcontroller::class, 'daily_reporting'])->name('dashboard.daily_reporting');
        Route::post('/filter_report', [dashboardcontroller::class, 'filter_report'])->name('dashboard.filter_report');
        Route::post('/add', [dashboardcontroller::class, 'add_admin'])->name('dashboard.add_admin');
        Route::post('/admin/trash/{id}', [dashboardcontroller::class, 'trash_admin'])->name('dashboard.trash_admin');
    });
});
Route::get('/book/tickets/7/{id}', [dashboardcontroller::class, 'view_ticket_7'])->name('dashboard.view_ticket_7');
Route::get('/book/tickets/10/{id}', [dashboardcontroller::class, 'view_ticket_10'])->name('dashboard.view_ticket_10');
Route::get('/book/tickets/11/{id}', [dashboardcontroller::class, 'view_ticket_11'])->name('dashboard.view_ticket_11');
Route::get('/book/tickets/14/{id}', [dashboardcontroller::class, 'view_ticket_14'])->name('dashboard.view_ticket_14');
Route::get('/book/tickets/16/{id}', [dashboardcontroller::class, 'view_ticket_16'])->name('dashboard.view_ticket_16');

 Route::get('/print/ticket/{ticket_no}', [pagescontroller::class, 'print_ticket'])->name('print_ticket');
// Route::get('/scheduled', [pagescontroller::class, 'scheduled'])->name('test.scheduled');

// Route::get('/route/1_1', [pagescontroller::class, 'single_route'])->name('single_route');
// Route::get('/contact_1', [pagescontroller::class, 'contact'])->name('contact');
