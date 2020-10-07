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
