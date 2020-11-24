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
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'UserController@store');
    Route::post('/verify', 'UserController@verify');
    Route::post('/{user}/forgot', 'UserController@forgotPassword');
    Route::post('/password', 'UserController@changePassword');
    Route::middleware('jwt:api')->get('/export', 'UserController@export');
    Route::middleware('jwt:api')->get('/types', 'UserController@listTypes');
    Route::middleware('jwt:api')->post('/{user}/role', 'UserController@assignRoleToUser');
    Route::middleware('jwt:api')->post('/{user}/approve', 'UserController@approve');
    Route::middleware('jwt:api')->post('/{user}/confirmation', 'UserController@resendConfirmation');
    Route::middleware('jwt:api')->post('/registerAdmin', 'UserController@createAccount');

});
Route::middleware('jwt:api')->resource('/users', UserController::class)->except(['edit', 'create']);
