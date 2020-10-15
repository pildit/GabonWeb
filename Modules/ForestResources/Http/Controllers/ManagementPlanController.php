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
     * @param ManagementPlanService $managementplanService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request,ManagementPlanService $managementplanService)
    {
        $managementplanService->validateRequest($request);
        $managementplanService->setPage($request->get('page'));
        $managementplanService->setPerPage($request->get('per_page'));
        $managementplanService->setSearch($request->get('search'));

        return response()->json($managementplanService->getPaginator());
    }
    /**
     * Store managementplan
     * @param CreateManagementPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateManagementPlanRequest $request)
    {
        $data = $request->validated();
        if (ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->count() > 0) {
            return response()->json([
                'message' => lang("managementplan_developmentunit_species_exist")
            ], 200);
        }

        $managementplan = ManagementPlan::create($data);

        return response()->json([
            'message' => lang("managementplan_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ManagementPlan $managementplan)
    {
        return response()->json(['data' => $managementplan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateManagementPlanRequest $request
     * @param ManagementPlan $managementplan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateManagementPlanRequest $request, ManagementPlan $managementplan)
    {
        $data = $request->validated();

        if (ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->where('Id', '!=', $managementplan->get()[0]->Id)->count() > 0) {
            return response()->json([
                'message' => lang("managementplan_developmentunit_species_exist")
            ], 200);
        } elseif( ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->where('Id', '=', $managementplan->get()[0]->Id)->count() > 0) {
            unset($data['ManagementUnit']);
            unset($data['Species']);
        }

        $managementplan->update($data);

        return response()->json([
            'message' => lang('managementplan_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ManagementPlan $managementplan)
    {
        //$data['status'] = timestamp();
        //$managementplan->fill($data);
        //$managementplan->save($data);

    }


}
