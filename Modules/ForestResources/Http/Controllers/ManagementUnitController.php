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
    public function index(Request $request,ManagementUnitService $managementunitService)
    {
        $managementunitService->validateRequest($request);
        $managementunitService->setPage($request->get('page'));
        $managementunitService->setPerPage($request->get('per_page'));
        $managementunitService->setSearch($request->get('search'));

        return response()->json($managementunitService->getPaginator());
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
        //$data['status'] = timestamp();
        //$managementunit->fill($data);
        //$managementunit->save($data);

    }


}
