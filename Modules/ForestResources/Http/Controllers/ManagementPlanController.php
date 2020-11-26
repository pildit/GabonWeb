<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\ForestResources\Entities\ManagementPlan;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateManagementPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementPlanRequest;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

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


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ['ManagementUnit','Species','GrossVolumeUFG','GrossVolumeYear','YieldVolumeYear','CommercialVolumeYear'];
        $collection = ManagementPlan::select('Id','ManagementUnit','Species','GrossVolumeUFG','GrossVolumeYear','YieldVolumeYear','CommercialVolumeYear');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();
        $collection = $collection->map(function ($item) {

            $Species = (Species::select("CommonName")->where("Id", $item->Species)->first()) ?
                Species::select("CommonName")->where("Id", $item->Species)->first()->CommonName :
                $item->Species;

            $ManagementUnit = (ManagementUnit::select("Name")->where("Id", $item->ManagementUnit)->first()) ?
                ManagementUnit::select("Name")->where("Id", $item->ManagementUnit)->first()->Name :
                $item->ManagementUnit;

            return [
                'ManagementUnit' => $ManagementUnit,
                'Species'  => $Species,
                'GrossVolumeUFG'  => $item->GrossVolumeUFG,
                'GrossVolumeYear'  => $item->GrossVolumeYear,
                'YieldVolumeYear'  => $item->YieldVolumeYear,
                'CommercialVolumeYear'  => $item->CommercialVolumeYear
            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'management_plan.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listManagementPlans(Request $request)
    {
        $management_plans = ManagementPlan::where('Number', 'ilike', "%{$request->get('name')}%")
            ->take($request->get('limit', 100))
            ->get(['Id', 'Number']);

        return response()->json([
            'data' => $management_plans->map(function ($management_plan) {
                return [
                    'Id' => $management_plan->Id,
                    'Number' => $management_plan->Number
                ];
            })
        ]);
    }
}
