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

Route::middleware('jwt:api')->resource('/roles', 'RolesController')->except(['create', 'edit']);
Route::middleware('jwt:api')->resource('/permissions', 'PermissionController')->except(['create', 'edit']);
