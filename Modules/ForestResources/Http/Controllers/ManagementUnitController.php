<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Http\Requests\CreateManagementUnitRequest;
use Modules\ForestResources\Http\Requests\UpdateManagementUnitRequest;


class ManagementUnitController extends Controller
{
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
