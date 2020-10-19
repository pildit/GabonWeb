<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Http\Requests\CreateManagementUnitRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementUnitRequest;
use Modules\ForestResources\Services\ManagementUnit as ManagementUnitService;


class ManagementUnitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request,ManagementUnitService $managementUnitService)
    {
        $managementUnitService->validateRequest($request);
        $managementUnitService->setPage($request->get('page'));
        $managementUnitService->setPerPage($request->get('per_page'));
        $managementUnitService->setSearch($request->get('search'));

        return response()->json($managementUnitService->getPaginator());
    }
    /**
     * Store managementUnit
     * @param CreateManagementUnitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateManagementUnitRequest $request)
    {
        $data = $request->validated();

        $managementUnit = ManagementUnit::create($data);

        return response()->json([
            'message' => lang("managementUnit_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ManagementUnit $managementUnit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ManagementUnit $managementUnit)
    {
        return response()->json(['data' => $managementUnit->get()->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ManagementUnit $managementUnit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateManagementUnitRequest $request, ManagementUnit $managementUnit)
    {

        $data = $request->validated();

        $managementUnit->update($data);

        return response()->json([
            'message' => lang('managementUnit_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ManagementUnit $managementUnit)
    {
        //$data['status'] = timestamp();
        //$managementUnit->fill($data);
        //$managementUnit->save($data);

    }


}
