<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Customer API routes - Added auth middleware to protect this route
Route::middleware('auth')->get('/customers/{id}', [CustomerController::class, 'show']);

// Provider API routes
Route::middleware('auth')->group(function() {
    Route::get('/providers/{id}', [AdminController::class, 'getProviderDetails']);
    Route::post('/providers', [AdminController::class, 'storeProvider']);
    Route::put('/providers/{id}', [AdminController::class, 'updateProviderApi']);
    Route::delete('/providers/{id}', [AdminController::class, 'deleteProvider']);
});
