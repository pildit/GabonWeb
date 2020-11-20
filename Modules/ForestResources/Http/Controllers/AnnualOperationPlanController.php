<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Entities\AnnualOperationPlan;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateAnnualOperationPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualOperationPlanRequest;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class AnnualOperationPlanController extends Controller
{

    /**
     * Store annualoperationplan
     * @param CreateAnnualOperationPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnualOperationPlanRequest $request)
    {
        $data = $request->validated();

        $annualoperationplan = AnnualOperationPlan::create($data);

        return response()->json([
            'message' => lang("annualoperationplan_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AnnualOperationPlan $annualoperationplan)
    {
        return response()->json(['data' => $annualoperationplan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnualOperationPlanRequest $request
     * @param AnnualOperationPlan $annualoperationplan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnualOperationPlanRequest $request, AnnualOperationPlan $annualoperationplan)
    {
        $data = $request->validated();
        $annualoperationplan->update($data);

        return response()->json([
            'message' => lang('annualoperationplan_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AnnualOperationPlan $annualoperationplan)
    {
        $annualoperationplan->delete();

        return response()->json([
            'message' => lang('annualoperationplan_delete_successful')
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

        $headings = ['AnnualAllowableCut','Species','ExploitableVolume','NonExploitableVolume','VolumePerHectare','AverageVolume','TotalVolume'];
        $collection = AnnualAllowableCutInventory::select('Id','AnnualAllowableCut','Species','ExploitableVolume','NonExploitableVolume','VolumePerHectare','AverageVolume','TotalVolume');

        if ($request->get('date_from')) {
            $collection = $collection->where("CreatedAt", ">=", $request->get('date_from'));
        }
        if ($request->get('date_to')) {
            $collection = $collection->where("CreatedAt", "<=", $request->get('date_to'));
        }
        $collection = $collection->get();

        $collection = $collection->map(function ($item) {

            $AnnualAllowableCut = (AnnualAllowableCut::select("Name")->where("Id", $item->AnnualAllowableCut)->first()) ?
                AnnualAllowableCut::select("Name")->where("Id", $item->AnnualAllowableCut)->first()->Name :
                $item->AnnualAllowableCut;

            $Species = (Species::select("CommonName")->where("Id", $item->Species)->first()) ?
                Species::select("CommonName")->where("Id", $item->Species)->first()->CommonName :
                $item->Species;

            return [
                'AnnualAllowableCut' => $AnnualAllowableCut,
                'Species' => $Species,
                'ExploitableVolume'=>$item->ExploitableVolume,
                'NonExploitableVolume'=>$item->NonExploitableVolume,
                'VolumePerHectare'=>$item->VolumePerHectare,
                'AverageVolume'=>$item->AverageVolume,
                'TotalVolume'=>$item->TotalVolume
            ];
        });

        return Excel::download(new Exporter($collection, $headings), 'annual_operation_plan.xlsx');
    }
}
