<?php

use App\Http\Controllers\POSController;
use App\Http\Controllers\ShiftController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// POS API endpoints
Route::middleware(['auth:sanctum', 'role:sales|admin'])->group(function () {
    Route::get('/pos/products', [POSController::class, 'getProducts'])->name('api.pos.products');
    Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('api.pos.checkout');
});

// Shift/Clock-in API endpoints
Route::middleware(['auth:sanctum', 'role:sales|admin'])->group(function () {
    Route::post('/shifts/clock-in', [ShiftController::class, 'clockIn'])->name('api.shifts.clock-in');
    Route::post('/shifts/clock-out', [ShiftController::class, 'clockOut'])->name('api.shifts.clock-out');
});

