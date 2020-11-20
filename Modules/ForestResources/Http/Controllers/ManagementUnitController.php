<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Http\Requests\CreateManagementUnitRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementUnitRequest;
use Modules\ForestResources\Services\ManagementUnit as ManagementUnitService;

class ManagementUnitController extends Controller
{
    private $modelName = ManagementUnit::class;

    public function __construct()
    {
        $this->middleware('permission:management-unit(UFG).view')->only('index', 'show');

        $this->middleware('permission:management-unit(UFG).add')->only('store');

        $this->middleware('permission:management-unit(UFG).edit')->only('update');

        $this->middleware('permission:management-unit(UFG).approve')->only('approve');

        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, ManagementUnit::class , ['Name'], [
            'plans',
            'developmentUnit'
        ]));
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
     * @param ManagementUnit $management_unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ManagementUnit $management_unit)
    {
        return response()->json(['data' => $management_unit]);
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
}
