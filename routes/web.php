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

Route::get('/geoportal', function () {
   return view('geoportal');
});

Route::get('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/register', 'AuthController@register');
Route::get('/account/confirmation/{token}', 'AuthController@emailConfirmation');

Route::get('/roles', 'RoleController@index');

Route::get('/nomenclatures', 'NomenclaturesController@index');
Route::get('/companies', 'CompaniesController@index');
Route::get('/users', 'UserController@index');
Route::get('/nomenclatures/{nomenclature_type}', 'NomenclaturesController@index');
