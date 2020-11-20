<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Http\Requests\CreateManagementUnitRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementUnitRequest;
use Modules\ForestResources\Services\ManagementUnit as ManagementUnitService;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class ManagementUnitController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, ManagementUnit::class , ['Name'], ['plans','developmentUnit']));
    }

    /**
     * Store managementunit
     * @param CreateManagementUnitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateManagementUnitRequest $request)
    {
        $data = $request->validated();

        $managementunit = ManagementUnit::create($data);

        return response()->json([
            'message' => lang("managementunit_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ManagementUnit $managementunit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ManagementUnit $managementunit)
    {
        return response()->json(['data' => $managementunit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ManagementUnit $managementunit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateManagementUnitRequest $request, ManagementUnit $managementunit)
    {

        $data = $request->validated();

        $managementunit->update($data);

        return response()->json([
            'message' => lang('managementunit_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ManagementUnit $managementunit)
    {
        $managementunit->delete();

        return response()->json([
            'message' => lang('managementunit_delete_successful')
        ], 204);

    }

    /**
     * @param Request $request
     * @param ManagementUnitService $managementUnitService
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, ManagementUnitService $managementUnitService)
    {
        $request->validate(['bbox' => 'string']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'management_unit',
                'features' => $managementUnitService->getVectors($request->get('bbox', config('forestresources.default_bbox')))
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

        $headings  = ['Name','DevelopmentUnit'];
        $collection = ManagementUnit::select('Id','Name','DevelopmentUnit');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();
        $collection = $collection->map(function ($item) {

            $DevelopmentUnit = (DevelopmentUnit::select("Name")->where("Id", $item->DevelopmentUnit)->first()) ?
                DevelopmentUnit::select("Name")->where("Id", $item->DevelopmentUnit)->first()->Name :
                $item->DevelopmentUnit;

            return [
                'Name' => $item->Name,
                'DevelopmentUnit'  => $DevelopmentUnit
            ];

        });

        return Excel::download(new Exporter($collection,$headings), 'management_unit.xlsx');
    }
}
