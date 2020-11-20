<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\Concession;
use Modules\ForestResources\Entities\DevelopmentPlan;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Http\Requests\CreateDevelopmentUnitRequest;
use Modules\ForestResources\Http\Requests\UpdateDevelopmentUnitRequest;
use Modules\ForestResources\Services\DevelopmentUnit as DevelopmentUnitService;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class DevelopmentUnitController extends Controller
{

    /**
     * @param Request $request
     * @param PageResults $pr
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, DevelopmentUnit::class , ['Name','Start','End'],['concession','plans']));
    }
    /**
     * Store developmentunit
     * @param CreateDevelopmentUnitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateDevelopmentUnitRequest $request)
    {
        $data = $request->validated();

        $developmentunit = DevelopmentUnit::create($data);

        return response()->json([
            'message' => lang("developmentunit_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param DevelopmentUnit $development_unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DevelopmentUnit $development_unit)
    {
        return response()->json(['data' => $development_unit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DevelopmentUnit $development_unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDevelopmentUnitRequest $request, DevelopmentUnit $development_unit)
    {

        $data = $request->validated();

        $development_unit->update($data);

        return response()->json([
            'message' => lang('developmentunit_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(DevelopmentUnit $development_unit)
    {
        $development_unit->delete();

        return response()->json([
            'message' => lang('developmentunit_delete_successful')
        ], 204);

    }

    /**
     * @param Request $request
     * @param DevelopmentUnitService $developmentUnitService
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, DevelopmentUnitService $developmentUnitService)
    {
        $request->validate(['bbox' => 'string']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'development_unit',
                'features' => $developmentUnitService->getVectors($request->get('bbox', config('forestresources.default_bbox')))
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ['Name', 'Concession', 'Plan ID', 'Start', 'End'];
        $collection = DevelopmentUnit::select('Id', 'Name', 'Concession', 'Start', 'End');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();
        $collection = $collection->map(function ($item) {
            $concession = Concession::where("Id",$item->Concession)->first();
            $plans = implode(",",array_column(DevelopmentPlan::select("Id")->where("DevelopmentUnit",$item->Id)->get()->toArray(),"Id"));
            return [
                'Name' => $item->Name,
                'Concession' => $concession->Name,
                'Plan ID' => $plans,
                'Start' => $item->Start,
                'End' => $item->End,
            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'development_unit.xlsx');
    }
}
