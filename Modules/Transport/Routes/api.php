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
Route::middleware('jwt:api')->get('/permits/vectors', 'PermitController@vectors');
Route::middleware('jwt:api')->get('/permits/mobile', 'PermitController@mobile');
Route::middleware('jwt:api')->resource('/permits', PermitController::class)->except(['create', 'edit']);
Route::middleware('jwt:api')->get('/permit_items/mobile', 'PermitItemController@mobile');
Route::middleware('jwt:api')->resource('/permits/{permit}/items', PermitItemController::class)->except(['create', 'edit']);
Route::middleware('jwt:api')->post('/permits/{permit}/tracking', 'PermitController@storeTracking');
