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

Route::middleware('jwt:api')->group(function (){
    Route::resource('/roles', 'RolesController')->except(['create', 'edit']);
    Route::get('/roles/{role}/permissions', "PermissionController@showPermissions");
    Route::put('/roles/{role}/permissions', "PermissionController@permissions");
    Route::resource('/permissions', 'PermissionController')->only(['index', 'store']);
    Route::resource('/pages', 'PageController')->only('index');
    Route::resource('/companies', CompanyController::class)->except(['edit', 'create', 'delete']);
    Route::get('/mobile_maps', 'MapController@mobileFeatures');
});

Route::get('/menu', 'MenuController@index');


