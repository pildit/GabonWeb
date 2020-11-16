<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Entities\AnnualAllowableCutInventory;
use Modules\ForestResources\Http\Requests\CreateAnnualAllowableCutInventoryRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualAllowableCutInventoryRequest;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Services\AnnualAllowableCutInventory as AnnualAllowableCutInventoryService;


class AnnualAllowableCutInventoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param PageResults $pr
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, AnnualAllowableCutInventory::class, ['AnnualAllowableCut']));
    }

    /**
     * Store annual_allowable_cut_inventory
     * @param CreateAnnualAllowableCutInventoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnualAllowableCutInventoryRequest $request)
    {
        $data = $request->validated();

        $srid = config('forestresources.srid');
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lon']}, {$data['Lat']}),4326),$srid)";
        $data['Geometry'] = isset($data['Geometry']) ? DB::raw("public.st_geomfromtext('".$data['Geometry']."', 5223)") : DB::raw("(select $geomQuery)");

        $annual_allowable_cut_inventory = AnnualAllowableCutInventory::create($data);

        return response()->json([
            'message' => lang("annual_allowable_cut_inventory_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AnnualAllowableCutInventory $annual_allowable_cut_inventory)
    {
        return response()->json(['data' => $annual_allowable_cut_inventory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnualAllowableCutInventoryRequest $request
     * @param AnnualAllowableCutInventory $annual_allowable_cut_inventory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnualAllowableCutInventoryRequest $request, AnnualAllowableCutInventory $annual_allowable_cut_inventory)
    {
        $data = $request->validated();

        $srid = config('forestresources.srid');
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lon']}, {$data['Lat']}),4326),$srid)";
        $data['Geometry'] = isset($data['Geometry']) ? DB::raw("public.st_geomfromtext('".$data['Geometry']."', 5223)") : DB::raw("(select $geomQuery)");

        $annual_allowable_cut_inventory->update($data);

        return response()->json([
            'message' => lang('annual_allowable_cut_inventory_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AnnualAllowableCutInventory $annual_allowable_cut_inventory)
    {
        $annual_allowable_cut_inventory->delete();

        return response()->json([
            'message' => lang('annual_allowable_cut_inventory_delete_successful')
        ], 204);


    }


    /**
     * @param AnnualAllowableCutInventoryService $aaciService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(AnnualAllowableCutInventoryService $aaciService)
    {
        $form = $aaciService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }

    /**
     * @param Request $request
     * @param AnnualAllowableCutInventoryService $aaciService
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, AnnualAllowableCutInventoryService $aaciService)
    {
        $request->validate(['bbox' => 'string']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'annual_allowable_cut_inventory',
                'features' => $aaciService->getVectors($request->get('bbox', config('forestresources.default_bbox')))
            ]
        ]);
    }
}
