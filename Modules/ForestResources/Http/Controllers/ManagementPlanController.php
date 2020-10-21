<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ManagementPlan;
use Modules\ForestResources\Http\Requests\CreateManagementPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementPlanRequest;
use Modules\ForestResources\Services\ManagementPlan as ManagementPlanService;

class ManagementPlanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param ManagementPlanService $managementPlanService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request,ManagementPlanService $managementPlanService)
    {
        $managementPlanService->validateRequest($request);
        $managementPlanService->setPage($request->get('page'));
        $managementPlanService->setPerPage($request->get('per_page'));
        $managementPlanService->setSearch($request->get('search'));

        return response()->json($managementPlanService->getPaginator());
    }
    /**
     * Store managementPlan
     * @param CreateManagementPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateManagementPlanRequest $request)
    {
        $data = $request->validated();
        if (ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->count() > 0) {
            return response()->json([
                'message' => lang("managementPlan_developmentunit_species_exist")
            ], 200);
        }

        $managementPlan = ManagementPlan::create($data);

        return response()->json([
            'message' => lang("managementPlan_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ManagementPlan $managementPlan)
    {
        return response()->json(['data' => $managementPlan->get()->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateManagementPlanRequest $request
     * @param ManagementPlan $managementPlan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateManagementPlanRequest $request, ManagementPlan $managementPlan)
    {
        $data = $request->validated();

        if (ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->where('Id', '!=', $managementPlan->get()[0]->Id)->count() > 0) {
            return response()->json([
                'message' => lang("managementPlan_developmentunit_species_exist")
            ], 200);
        } elseif( ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->where('Id', '=', $managementPlan->get()[0]->Id)->count() > 0) {
            unset($data['ManagementUnit']);
            unset($data['Species']);
        }

        $managementPlan->update($data);

        return response()->json([
            'message' => lang('managementPlan_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ManagementPlan $managementPlan)
    {
        //$data['status'] = timestamp();
        //$managementPlan->fill($data);
        //$managementPlan->save($data);

    }


}
