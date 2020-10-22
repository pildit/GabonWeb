<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCutInventory;
use Modules\ForestResources\Http\Requests\CreateAnnualAllowableCutInventoryRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualAllowableCutInventoryRequest;
use Illuminate\Support\Facades\DB;

class AnnualAllowableCutInventoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param AnnualAllowableCutInventoryService $annualallowablecutinventoryService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, AnnualAllowableCutInventory::class , ['AnnualAllowableCut']));
    }

    /**
     * Store annualallowablecutinventory
     * @param CreateAnnualAllowableCutInventoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnualAllowableCutInventoryRequest $request)
    {
        $data = $request->validated();

        $annualallowablecutinventory = AnnualAllowableCutInventory::create($data);

        return response()->json([
            'message' => lang("annualallowablecutinventory_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AnnualAllowableCutInventory $annualallowablecutinventory)
    {
        return response()->json(['data' => $annualallowablecutinventory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnualAllowableCutInventoryRequest $request
     * @param AnnualAllowableCutInventory $annualallowablecutinventory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnualAllowableCutInventoryRequest $request, AnnualAllowableCutInventory $annualallowablecutinventory)
    {
        $data = $request->validated();
        $annualallowablecutinventory->update($data);

        return response()->json([
            'message' => lang('annualallowablecutinventory_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AnnualAllowableCutInventory $annualallowablecutinventory)
    {
        //$data['status'] = timestamp();
        //$annualallowablecutinventory->fill($data);
        //$annualallowablecutinventory->save($data);

    }


}
