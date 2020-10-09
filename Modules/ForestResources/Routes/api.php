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
Route::prefix('parcels')->group(function () {
    Route::middleware('jwt:api')->post('/store', 'ParcelController@store');
    Route::middleware('jwt:api')->put('/update', 'ParcelController@update');
    Route::middleware('jwt:api')->post('/show', 'ParcelController@show');
    Route::middleware('jwt:api')->post('/destroy', 'ParcelController@destroy');
});

Route::middleware('jwt:api')->resource('/developmentunit', DevelopmentUnitController::class)->except(['edit', 'create']);
Route::prefix('developmentunit')->group(function () {
    Route::middleware('jwt:api')->post('/store', 'DevelopmentUnitController@store');
    Route::middleware('jwt:api')->put('/update', 'DevelopmentUnitController@update');
    Route::middleware('jwt:api')->post('/show', 'DevelopmentUnitController@show');
    Route::middleware('jwt:api')->post('/destroy', 'DevelopmentUnitController@destroy');
});

Route::middleware('jwt:api')->resource('/developmentplan', DevelopmentPlanController::class)->except(['edit', 'create']);
Route::prefix('developmentplace')->group(function () {
    Route::middleware('jwt:api')->post('/store', 'DevelopmentPlanController@store');
    Route::middleware('jwt:api')->put('/update', 'DevelopmentPlanController@update');
    Route::middleware('jwt:api')->post('/show', 'DevelopmentPlanController@show');
    Route::middleware('jwt:api')->post('/destroy', 'DevelopmentPlanController@destroy');
});

