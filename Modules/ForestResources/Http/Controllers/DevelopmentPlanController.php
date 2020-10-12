<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\DevelopmentPlan;
use Modules\ForestResources\Http\Requests\CreateDevelopmentPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateDevelopmentPlanRequest;
use Modules\ForestResources\Services\DevelopmentPlan as DevelopmentPlanService;

class DevelopmentPlanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param DevelopmentPlanService $developmentPlanService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
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
     * @param CreateDevelopmentPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateDevelopmentPlanRequest $request)
    {
        $data = $request->validated();
        if (DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->count() > 0) {
            return response()->json([
                'message' => lang("developmentPlan_developmentunit_species_exist")
            ], 200);
        }

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
        return response()->json(['data' => $developmentPlan->get()->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDevelopmentPlanRequest $request
     * @param DevelopmentPlan $developmentPlan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDevelopmentPlanRequest $request, DevelopmentPlan $developmentPlan)
    {
        $data = $request->validated();

        if (DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->where('Id', '!=', $developmentPlan->get()[0]->Id)->count() > 0) {
            return response()->json([
                'message' => lang("developmentPlan_developmentunit_species_exist")
            ], 200);
        } elseif( DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->where('Id', '=', $developmentPlan->get()[0]->Id)->count() > 0) {
            unset($data['DevelopmentUnit']);
            unset($data['Species']);
        }

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
