<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Http\Requests\CreateDevelopmentUnitRequest;
use Modules\ForestResources\Http\Requests\UpdateDevelopmentUnitRequest;
use Modules\ForestResources\Services\DevelopmentUnit as DevelopmentUnitService;

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
     * @param DevelopmentUnit $developmentunit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DevelopmentUnit $developmentunit)
    {
        return response()->json(['data' => $developmentunit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DevelopmentUnit $developmentunit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDevelopmentUnitRequest $request, DevelopmentUnit $developmentunit)
    {

        $data = $request->validated();

        $developmentunit->update($data);

        return response()->json([
            'message' => lang('developmentunit_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(DevelopmentUnit $developmentunit)
    {
        $developmentunit->delete();

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
}
