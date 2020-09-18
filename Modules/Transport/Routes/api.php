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
Route::get('/permits/vectors', 'PermitController@vectors');
Route::get('/permits/mobile', 'PermitController@mobile');
Route::resource('/permits', PermitController::class)->except(['create', 'edit']);
Route::get('/permit_items/mobile', 'PermitItemController@mobile');
Route::resource('/permits/{permit}/items', PermitItemController::class)->except(['create', 'edit']);
