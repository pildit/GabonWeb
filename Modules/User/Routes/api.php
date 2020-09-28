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


Route::prefix('users')->group(function () {
    Route::middleware('jwt:api')->resource('/', UserController::class)->except(['edit', 'create']);
    Route::post('/register', 'UserController@store');
    Route::post('/verify', 'UserController@verify');
    Route::post('/{user}/forgot', 'UserController@forgotPassword');
    Route::post('/password', 'UserController@changePassword');
    Route::middleware('jwt:api')->post('/{user}/assignRole', 'UserController@assignRoleToUser');
    Route::middleware('checkstatus')->post('/login', 'AuthController@login');
    Route::middleware('jwt:api')->post('/{user}/approve', 'UserController@approve');
    Route::middleware('jwt:api')->post('/{user}/confirmation', 'UserController@resendConfirmation');
    Route::middleware('jwt:api')->post('/registerAdmin', 'UserController@createAccount');

});



