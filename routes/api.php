<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apis\apiscontroller;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('api_token')->group(function() {
    Route::prefix('xwift/{api_token}')->group(function() {
        Route::post('/routes', [apiscontroller::class, 'routes']);
    });
});
