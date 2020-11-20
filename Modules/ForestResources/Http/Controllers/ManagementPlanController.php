<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ManagementPlan;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateManagementPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementPlanRequest;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class ManagementPlanController extends Controller
{
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
}
