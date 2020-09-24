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
Route::post('/login', 'AuthController@login');
Route::post('/register', 'UserController@store');

Route::resource('/users', UserController::class)->except(['edit', 'create']);

Route::post('/users/{user}/assignRole', 'UserController@assignRoleToUser');