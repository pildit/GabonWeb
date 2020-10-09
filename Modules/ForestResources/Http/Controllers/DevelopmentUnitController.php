<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Http\Requests\CreateUpdateDevelopmentUnitRequest;
use ShapeFile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Modules\ForestResources\Services\DevelopmentUnit as DevelopmentUnitService;
use Shapefile\Geometry\Polygon;
use Illuminate\Support\Facades\File;

class DevelopmentUnitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request,DevelopmentUnitService $developmentUnitService)
    {
        $developmentUnitService->validateRequest($request);
        $developmentUnitService->setPage($request->get('page'));
        $developmentUnitService->setPerPage($request->get('per_page'));
        $developmentUnitService->setSearch($request->get('search'));

        return response()->json($developmentUnitService->getPaginator());
    }
    /**
     * Store developmentUnit
     * @param CreateUpdateDevelopmentUnitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUpdateDevelopmentUnitRequest $request)
    {
        $data = $request->validated();

        $developmentUnit = DevelopmentUnit::create($data);

        return response()->json([
            'message' => lang("developmentUnit_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DevelopmentUnit $developmentUnit)
    {
        return response()->json(['data' => $developmentUnit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DevelopmentUnit $developmentUnit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUpdateDevelopmentUnitRequest $request, DevelopmentUnit $developmentUnit)
    {

        $data = $request->validated();

        $developmentUnit->fill($data);
        $developmentUnit->save($data);

        return response()->json([
            'message' => lang('developmentUnit_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(DevelopmentUnit $developmentUnit)
    {
        //$data['status'] = timestamp();
        //$developmentUnit->fill($data);
        //$developmentUnit->save($data);

    }


}
