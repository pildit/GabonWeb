<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\ForestResources\Entities\ManagementPlan;
use Modules\ForestResources\Http\Requests\CreateManagementPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementPlanRequest;

class ManagementPlanController extends Controller
{
    private $modelName = ManagementPlan::class;

    public function __construct()
    {
        $this->middleware('permission:management-unit.view')->only('index', 'show');

        $this->middleware('permission:management-unit.add')->only('store');

        $this->middleware('permission:management-unit.edit')->only('update');

        $this->middleware('permission:management-unit.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

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
            throw  ValidationException::withMessages(['$management_plan' => lang("managementplan_developmentunit_species_exist")]);
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
     * @param ManagementPlan $management_plan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateManagementPlanRequest $request, ManagementPlan $management_plan)
    {
        $data = $request->validated();

        if (ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->where('Id', '!=', $management_plan->Id)->count() > 0) {
            throw  ValidationException::withMessages(['$management_plan' => lang("managementplan_developmentunit_species_exist")]);
        } elseif( ManagementPlan::where('ManagementUnit', $data['ManagementUnit'])->where('Species', $data['Species'])->where('Id', '=', $management_plan->Id)->count() > 0) {
            unset($data['ManagementUnit']);
            unset($data['Species']);
        }

        $management_plan->update($data);

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
        $managementplan->delete();

        return response()->json([
            'message' => lang('managementplan_delete_successful')
        ], 204);
    }


}
