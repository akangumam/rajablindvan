<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\RentalController;
use App\Http\Controllers\Api\MonitoringController;
use App\Http\Controllers\Api\HistoryController;

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

// Public routes
Route::prefix('v1')->group(function () {
    // Authentication — maks 5 percobaan per menit per IP
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

// Protected routes
Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/monthly-revenue', [DashboardController::class, 'monthlyRevenue']);

    // Vehicles (Read-Only)
    Route::prefix('vehicles')->group(function () {
        Route::get('/', [VehicleController::class, 'index']);
        Route::get('/{id}', [VehicleController::class, 'show']);
        Route::get('/{id}/rentals', [VehicleController::class, 'rentals']);
        Route::get('/{id}/maintenances', [VehicleController::class, 'maintenances']);
    });

    // Rentals (Read-Only)
    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index']);
        Route::get('/active', [RentalController::class, 'active']);
        Route::get('/{id}', [RentalController::class, 'show']);
    });

    // Monitoring (Read-Only)
    Route::prefix('monitoring')->group(function () {
        Route::get('/stnk-overdue', [MonitoringController::class, 'stnkOverdue']);
        Route::get('/kir-overdue', [MonitoringController::class, 'kirOverdue']);
        Route::get('/gps-overdue', [MonitoringController::class, 'gpsOverdue']);
    });

    // History (Read-Only)
    Route::prefix('history')->group(function () {
        Route::get('/', [HistoryController::class, 'index']);
        Route::get('/stats', [HistoryController::class, 'stats']);
    });
    Route::get('/vehicles/{vehicleId}/next-refueling', [HistoryController::class, 'nextRefueling']);
});
