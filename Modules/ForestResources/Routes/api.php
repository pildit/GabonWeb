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



//constituent permit
Route::middleware('jwt:api')->get('/constituent_permits/export', 'ConstituentPermitController@export');
Route::middleware('jwt:api')->patch('/constituent_permits/approve/{id}', 'ConstituentPermitController@approve');
Route::middleware('jwt:api')->resource('/constituent_permits', ConstituentPermitController::class)->except(['create', 'edit']);
//Parcel
Route::middleware('jwt:api')->get('/parcels/export', 'ParcelController@export');
Route::middleware('jwt:api')->patch('/parcels/approve/{id}', 'ParcelController@approve');
Route::get('/parcels/vectors', 'ParcelController@vectors');
Route::middleware('jwt:api')->resource('/parcels', ParcelController::class)->except(['edit', 'create']);
//development unit
Route::get('/development_units/vectors', 'DevelopmentUnitController@vectors');
Route::middleware('jwt:api')->get('/development_units/list', 'DevelopmentUnitController@listDevelopmentUnits');
Route::middleware('jwt:api')->get('/development_units/export', 'DevelopmentUnitController@export');
Route::middleware('jwt:api')->patch('/development_units/approve/{id}', 'DevelopmentUnitController@approve');
Route::middleware('jwt:api')->resource('/development_units', DevelopmentUnitController::class)->except(['edit', 'create']);
//development plan
Route::middleware('jwt:api')->get('/development_plans/export', 'DevelopmentPlanController@export');
Route::middleware('jwt:api')->resource('/development_plans', DevelopmentPlanController::class)->except(['edit', 'create']);
//management plan
Route::middleware('jwt:api')->get('/management_plans/export', 'ManagementPlanController@export');
Route::middleware('jwt:api')->patch('/management_plans/approve/{id}', 'ManagementPlanController@approve');
Route::middleware('jwt:api')->resource('/management_plans', ManagementPlanController::class)->except(['edit', 'create']);
//management unit
Route::middleware('jwt:api')->get('/management_units/export', 'ManagementUnitController@export');
Route::get('/management_units/vectors', 'ManagementUnitController@vectors');
Route::middleware('jwt:api')->patch('/management_units/approve/{id}', 'ManagementUnitController@approve');
Route::middleware('jwt:api')->resource('/management_units', ManagementUnitController::class)->except(['edit', 'create']);
//concession
Route::middleware('jwt:api')->get('/concessions/export', 'ConcessionsController@export');
Route::get('/concessions/vectors', 'ConcessionsController@vectors');
Route::middleware('jwt:api')->get('/concessions/list', 'ConcessionsController@listConcessions');
Route::middleware('jwt:api')->patch('/concessions/approve/{id}', 'ConcessionsController@approve');
Route::middleware('jwt:api')->resource('/concessions', ConcessionsController::class)->except(['edit', 'create']);
//AAC
Route::middleware('jwt:api')->get('/annual_allowable_cuts/export', 'AnnualAllowableCutController@export');
Route::get('/annual_allowable_cuts/vectors', 'AnnualAllowableCutController@vectors');
Route::middleware('jwt:api')->patch('/annual_allowable_cuts/approve/{id}', 'AnnualAllowableCutController@approve');
Route::middleware('jwt:api')->resource('/annual_allowable_cuts', AnnualAllowableCutController::class)->except(['edit', 'create']);
//Annual operation plans
Route::middleware('jwt:api')->patch('/annual_operation_plans/approve/{id}', 'AnnualOperationPlanController@approve');
Route::middleware('jwt:api')->resource('/annual_operation_plans', AnnualOperationPlanController::class)->except(['edit', 'create']);
//AAC Inventory
Route::middleware('jwt:api')->get('/annual_allowable_cut_inventory/export', 'AnnualAllowableCutInventoryController@export');
Route::middleware('jwt:api')->get('/annual_allowable_cut_inventory/mobile', 'AnnualAllowableCutInventoryController@mobile');
Route::get('/annual_allowable_cut_inventory/vectors', 'AnnualAllowableCutInventoryController@vectors');
Route::middleware('jwt:api')->post('/annual_allowable_cut_inventory/approve/{id}', 'AnnualAllowableCutInventoryController@approve');
Route::middleware('jwt:api')->resource('/annual_allowable_cut_inventory', AnnualAllowableCutInventoryController::class)->except(['edit', 'create']);
//logbook
Route::middleware('jwt:api')->get('/logbooks/export', 'LogbookController@export');
Route::middleware('jwt:api')->get('/logbooks/mobile', 'LogbookController@mobile');
Route::middleware('jwt:api')->patch('/logbooks/approve/{id}', 'LogbookController@approve');
Route::middleware('jwt:api')->resource('/logbooks', LogbookController::class)->except(['edit', 'create']);
//logbook item
Route::middleware('jwt:api')->get('/logbook_items/export', 'LogbookItemController@export');
Route::middleware('jwt:api')->get('/logbook_items/mobile', 'LogbookItemController@mobile');
Route::middleware('jwt:api')->patch('/logbook_items/approve/{id}', 'LogbookItemController@approve');
Route::middleware('jwt:api')->resource('/logbook_items', LogbookItemController::class)->except(['edit', 'create']);
//Sitelogbook
Route::middleware('jwt:api')->get('/site_logbooks/export', 'SiteLogbookController@export');
Route::middleware('jwt:api')->get('/site_logbooks/mobile', 'SiteLogbookController@mobile');
Route::middleware('jwt:api')->resource('/site_logbooks', SiteLogbookController::class)->except(['edit', 'create']);
//Sitelogbook items
Route::middleware('jwt:api')->get('/site_logbook_items/export', 'SiteLogbookItemController@export');
Route::middleware('jwt:api')->get('/site_logbook_items/mobile', 'SiteLogbookItemController@mobile');
Route::middleware('jwt:api')->resource('/site_logbook_items', SiteLogbookItemController::class)->except(['edit', 'create']);
//Sitelogbook logs
Route::middleware('jwt:api')->get('/site_logbook_logs/export', 'SiteLogbookLogController@export');
Route::middleware('jwt:api')->get('/site_logbook_logs/mobile', 'SiteLogbookLogController@mobile');
Route::middleware('jwt:api')->resource('/site_logbook_logs', SiteLogbookLogController::class)->except(['edit', 'create']);
//Permit Types
Route::middleware('jwt:api')->get('/permit_types/export', 'PermitTypesController@export');
Route::middleware('jwt:api')->get('/permit_types/list', "PermitTypesController@listPermitTypes");
Route::middleware('jwt:api')->resource('/permit_types', PermitTypesController::class)->except(['edit', 'create']);
//Species
Route::middleware('jwt:api')->get('/species/export', 'SpeciesController@export');
Route::middleware('jwt:api')->get('/species/list', "SpeciesController@listSpecies");
Route::middleware('jwt:api')->resource('/species', SpeciesController::class)->except(['edit', 'create']);
//Quality
Route::middleware('jwt:api')->get('/quality/export', 'QualityController@export');
Route::middleware('jwt:api')->resource('/quality', QualityController::class)->except(['edit', 'create']);
//Product type
Route::middleware('jwt:api')->get('/product_type/export', 'ProductTypeController@export');
Route::middleware('jwt:api')->resource('/product_type', ProductTypeController::class)->except(['edit', 'create']);
