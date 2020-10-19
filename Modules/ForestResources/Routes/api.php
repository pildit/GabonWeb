<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt:api')->resource('/parcels', ParcelController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/developmentunits', DevelopmentUnitController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/developmentplans', DevelopmentPlanController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/concessions', ConcessionsController::class)->except(['edit', 'create']);
