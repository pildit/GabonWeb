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

Route::middleware('auth:api')->get('/forestresources', function (Request $request) {
    return $request->user();
});

Route::prefix('forestresources')->group(function () {
	Route::middleware('jwt:api')->resource('/cp', ConstituentPermitController::class);
});