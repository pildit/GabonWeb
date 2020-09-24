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
    Route::post('/approve/{user}', 'UserController@approve');
    Route::post('/resendconfirmation/{user}', 'UserController@resendConfirmation');
    Route::post('/forgotpassword/{user}', 'UserController@forgotPassword');
    Route::post('/changepassword', 'UserController@changePassword');
    Route::post('/createaccount', 'UserController@createAccount');
});
