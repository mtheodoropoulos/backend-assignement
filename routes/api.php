<?php

use App\Http\Controllers\VesselTrackCreateController;
use App\Http\Controllers\VesselTrackDeleteController;
use App\Http\Controllers\VesselTrackUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VesselController;

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

Route::middleware(['throttle:' . config('throttling.api.Vessels')])
    ->group(function () {
        Route::get('/vessels', [VesselController::class, 'index']);
        Route::get('/vessels/{mmsi}', [VesselController::class, 'show']);
    });

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/vessels', VesselTrackCreateController::class);
        Route::delete('/vessels', VesselTrackDeleteController::class);
        Route::patch('/vessels', VesselTrackUpdateController::class);
    });
