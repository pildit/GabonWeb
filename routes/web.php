<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/docs', function () {
    return view('docs.index');
});

Route::get('/geoportal', function () {
   return view('geoportal');
});


Route::get('/login', 'AuthController@login')->name('login');
Route::get('/logout', 'AuthController@logout');
Route::get('/register', 'AuthController@register');
Route::get('/account/confirmation/{token}', 'AuthController@emailConfirmation');

Route::middleware('auth.jwt')->group(function () {
    Route::get('/roles', 'RoleController@index');
    Route::get('/users', 'UserController@index');
    Route::get('/users/{user}/edit', 'UserController@edit');

    Route::get('/nomenclatures/{nomenclature_type?}', 'NomenclaturesController@index');

    Route::resource('/management/development-units', 'DevelopmentUnitController')->only(['create', 'edit']);
    Route::resource('/management/management-units', 'ManagementUnitController')->only(['create', 'edit']);
    Route::get('/management/{management_type?}', 'ManagementController@index');

    Route::get('/concessions/parcels', "ConcessionsController@parcels");
    Route::resource('/concessions/constituent-permits', 'ConstituentPermitController')->only(['index', 'create', 'edit']);
    Route::get('/concessions', 'ConcessionsController@resources');
    Route::get('/concessions/list', "ConcessionsController@index");
    Route::resource('/concessions', 'ConcessionsController')->only(['create', 'edit']);

    Route::get('/translations', 'TranslationController@index');
    Route::view('/logbooks', 'transportation.logbooks');
    Route::get('/sitelogbooks', 'SiteLogbookItemsController@index');
    Route::get('/sitelogbook', 'SiteLogbookItemsController@view');

});

