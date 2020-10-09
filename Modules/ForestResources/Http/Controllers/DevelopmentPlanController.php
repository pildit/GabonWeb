<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\DevelopmentPlan;
use Modules\ForestResources\Http\Requests\CreateUpdateDevelopmentPlanRequest;
use ShapeFile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Modules\ForestResources\Services\DevelopmentPlan as DevelopmentPlanService;
use Shapefile\Geometry\Polygon;
use Illuminate\Support\Facades\File;

class DevelopmentPlanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request,DevelopmentPlanService $developmentPlanService)
    {
        $developmentPlanService->validateRequest($request);
        $developmentPlanService->setPage($request->get('page'));
        $developmentPlanService->setPerPage($request->get('per_page'));
        $developmentPlanService->setSearch($request->get('search'));

        return response()->json($developmentPlanService->getPaginator());
    }
    /**
     * Store developmentPlan
     * @param CreateUpdateDevelopmentPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUpdateDevelopmentPlanRequest $request)
    {
        $data = $request->validated();

        $developmentPlan = DevelopmentPlan::create($data);

        return response()->json([
            'message' => lang("developmentPlan_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DevelopmentPlan $developmentPlan)
    {
        return response()->json(['data' => $developmentPlan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DevelopmentPlan $developmentPlan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUpdateDevelopmentPlanRequest $request, DevelopmentPlan $developmentPlan)
    {

        $data = $request->validated();

        $developmentPlan->fill($data);
        $developmentPlan->save($data);

        return response()->json([
            'message' => lang('developmentPlan_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(DevelopmentPlan $developmentPlan)
    {
        //$data['status'] = timestamp();
        //$developmentPlan->fill($data);
        //$developmentPlan->save($data);

    }


}
