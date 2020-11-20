<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\DevelopmentPlan;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateDevelopmentPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateDevelopmentPlanRequest;
use Modules\ForestResources\Services\DevelopmentPlan as DevelopmentPlanService;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class DevelopmentPlanController extends Controller
{
    /**
     * Store developmentplan
     * @param CreateDevelopmentPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateDevelopmentPlanRequest $request)
    {
        $data = $request->validated();
        if (DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->count() > 0) {
            return response()->json([
                'message' => lang("developmentplan_developmentunit_species_exist")
            ], 200);
        }

        $developmentplan = DevelopmentPlan::create($data);

        return response()->json([
            'message' => lang("developmentplan_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DevelopmentPlan $developmentplan)
    {
        return response()->json(['data' => $developmentplan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDevelopmentPlanRequest $request
     * @param DevelopmentPlan $developmentplan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDevelopmentPlanRequest $request, DevelopmentPlan $developmentplan)
    {
        $data = $request->validated();

        if (DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->where('Id', '!=', $developmentplan->get()[0]->Id)->count() > 0) {
            return response()->json([
                'message' => lang("developmentplan_developmentunit_species_exist")
            ], 200);
        } elseif( DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->where('Id', '=', $developmentplan->get()[0]->Id)->count() > 0) {
            unset($data['DevelopmentUnit']);
            unset($data['Species']);
        }

        $developmentplan->update($data);

        return response()->json([
            'message' => lang('developmentplan_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(DevelopmentPlan $developmentplan)
    {
        $developmentplan->delete();

        return response()->json([
            'message' => lang('developmentplan_delete_successful')
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

        $headings = ['DevelopmentUnit','Species','MinimumExploitableDiameter','VolumeTariff','Increment'];
        $collection = DevelopmentPlan::select('Id','DevelopmentUnit','Species','MinimumExploitableDiameter','VolumeTariff','Increment');

        if ($request->get('date_from')) {
            $collection = $collection->where("CreatedAt", ">=", $request->get('date_from'));
        }
        if ($request->get('date_to')) {
            $collection = $collection->where("CreatedAt", "<=", $request->get('date_to'));
        }
        $collection = $collection->get();

        $collection = $collection->map(function ($item) {

            $DevelopmentUnit = (DevelopmentUnit::select("Name")->where("Id", $item->DevelopmentUnit)->first()) ?
                    DevelopmentUnit::select("Name")->where("Id", $item->DevelopmentUnit)->first()->Name :
                    $item->DevelopmentUnit;

            $Species = (Species::select("CommonName")->where("Id", $item->Species)->first()) ?
                Species::select("CommonName")->where("Id", $item->Species)->first()->CommonName :
                $item->Species;

            return [
                'DevelopmentUnit'=>$DevelopmentUnit,
                'Species'=>$Species,
                'MinimumExploitableDiameter'=>$item->MinimumExploitableDiameter,
                'VolumeTariff'=>$item->VolumeTariff,
                'Increment'=>$item->Increment
            ];
        });

        return Excel::download(new Exporter($collection, $headings), 'development_plan.xlsx');
    }
}
