<?php

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
//Permit
Route::middleware('jwt:api')->get('/permits/export', 'PermitController@export');
Route::get('/permits/vectors', 'PermitController@vectors');
Route::middleware('jwt:api')->get('/permits/mobile', 'PermitController@mobile');
Route::middleware('jwt:api')->resource('/permits', PermitController::class)->except(['create', 'edit']);
Route::middleware('jwt:api')->patch('/permits/approve/{id}', 'PermitController@approve');
//Permit Item
Route::middleware('jwt:api')->get('/permit_items/export', 'PermitItemController@export');
Route::middleware('jwt:api')->get('/permit_items/mobile', 'PermitItemController@mobile');
Route::middleware('jwt:api')->resource('/permit_items', PermitItemController::class)->except(['create', 'edit']);
//Permit tracking
Route::middleware('jwt:api')->get('/permits_tracking/vectors', 'PermitController@trackingVectors');
Route::middleware('jwt:api')->post('/permits_tracking', 'PermitController@storeTracking');
//Permit nomenclators
Route::middleware('jwt:api')->get('/park_types', 'ParkTypeController@listParkTypes');
Route::middleware('jwt:api')->get('/transportation_types', 'TransportTypeController@listTransportTypes');
