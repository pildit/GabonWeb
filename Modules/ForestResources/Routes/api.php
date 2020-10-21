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


Route::middleware('jwt:api')->resource('/constituent_permits', ConstituentPermitController::class)->except(['create', 'edit']);
Route::middleware('jwt:api')->resource('/parcels', ParcelController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/concessions', ConcessionsController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/annualallowablecuts', AnnualAllowableCutController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/annualoperationplans', AnnualOperationPlanController::class)->except(['edit', 'create']);
Route::middleware('jwt:api')->resource('/annualallowablecutinventory', AnnualAllowableCutInventoryController::class)->except(['edit', 'create']);
