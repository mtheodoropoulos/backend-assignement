<?php

use App\Http\Controllers\V1\VesselTrackController;
use App\Http\Middleware\VesselTrackContentTypeHandler;
use Illuminate\Support\Facades\Route;

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

Route::middleware(VesselTrackContentTypeHandler::class)
    ->middleware(['throttle:' . config('throttling.api.VesselTracks')])
    ->group(function () {
        Route::get('/vessel-tracks', VesselTrackController::class);
    });
