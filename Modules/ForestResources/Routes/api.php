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

Route::middleware('jwt:api')->resource('/constituent_permits', ConstituentPermitController::class)->except(['create', 'edit']);
Route::middleware('jwt:api')->resource('/parcels', ParcelController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/development_units', DevelopmentUnitController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/development_plans', DevelopmentPlanController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/management_plans', ManagementPlanController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/management_units', ManagementUnitController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/concessions', ConcessionsController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/annual_allowable_cuts', AnnualAllowableCutController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/annual_operation_plans', AnnualOperationPlanController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->get('/annual_allowable_cut_inventory/mobile', 'AnnualAllowableCutInventoryController@mobile');
Route::middleware('jwt:api')->resource('/annual_allowable_cut_inventory', AnnualAllowableCutInventoryController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->get('/logbooks/mobile', 'LogbookController@mobile');
Route::middleware('jwt:api')->resource('/logbooks', LogbookController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->get('/logbook_items/mobile', 'LogbookItemController@mobile');
Route::middleware('jwt:api')->resource('/logbook_items', LogbookItemController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->get('/site_logbooks/mobile', 'SiteLogbookController@mobile');
Route::middleware('jwt:api')->resource('/site_logbooks', SiteLogbookController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->get('/site_logbook_items/mobile', 'SiteLogbookItemController@mobile');
Route::middleware('jwt:api')->resource('/site_logbook_items', SiteLogbookItemController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->get('/site_logbook_logs/mobile', 'SiteLogbookLogController@mobile');
Route::middleware('jwt:api')->resource('/site_logbook_logs', SiteLogbookLogController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/permit_types', PermitTypesController::class)->except(['edit', 'create']);