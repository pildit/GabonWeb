<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Http\Requests\CreateDevelopmentUnitRequest;
use Modules\ForestResources\Http\Requests\UpdateDevelopmentUnitRequest;
use Modules\ForestResources\Services\DevelopmentUnit as DevelopmentUnitService;
use App\Traits\Approve;

class DevelopmentUnitController extends Controller
{
    use GetsJwtToken, Approve;

    private $modelName = DevelopmentUnit::class;

    public function __construct()
    {
        $this->middleware('permission:development-unit.view')->only('index', 'show');

        $this->middleware('permission:development-unit.add')->only('store');

        $this->middleware('permission:development-unit.edit')->only('update');

        $this->middleware('permission:development-unit.approve')->only('approve');

        $this->middleware('role:admin')->only('delete');

    }

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
        $data['User'] = $this->jwtPayload('data.id');
        $developmentunit = DevelopmentUnit::create($data);

        return response()->json([
            'message' => lang("developmentunit_created_successfully"),
            'id' => $developmentunit->Id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param DevelopmentUnit $development_unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($development_unit)
    {
        $geomCol = DB::raw('public.ST_AsText("Geometry") as geometry_as_text');

        $development_unit = DevelopmentUnit::select()
            ->addSelect($geomCol)
            ->with(['plans'])->find($development_unit);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function listDevelopmentUnits(Request $request)
    {
        $concessions = DevelopmentUnit::where('Name', 'like', "%{$request->get('name')}%")
            ->take($request->get('limit', 100))
            ->get(['Id', 'Name']);

        return response()->json([
            'data' => $concessions->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'Name' => $item->Name
                ];
            })
        ]);

    }
}
