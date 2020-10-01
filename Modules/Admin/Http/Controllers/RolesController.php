<?php

namespace Modules\Admin\Http\Controllers;

use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Role as RoleEntity;
use Modules\Admin\Services\Role;

class RolesController extends Controller
{
    use GetsJwtToken;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request, Role $roleService)
    {
        $roleService->validateRequest($request);
        $roleService->setPage($request->get('page'));
        $roleService->setPerPage($request->get('per_page'));
        $roleService->setSearch($request->get('search'));

        return response()->json($roleService->getPaginator());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:Modules\Admin\Entities\Role,name'
        ]);

        $role = new RoleEntity();
        $role->fill($data);
        $role->save();

        return response()->json([
            'data' => $role
        ], 201);
    }

    /**
     * Show the specified resource.
     * @param RoleEntity $role
     * @return JsonResponse
     */
    public function show(RoleEntity $role)
    {
        return response()->json([
            "data" => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param RoleEntity $role
     * @return JsonResponse
     */
    public function update(Request $request, RoleEntity $role)
    {
        $data = $request->validate([
            'name' => 'string|unique:Modules\Admin\Entities\Role,name'
        ]);

        $role->update($data);

        return response()->json([
            'data' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(RoleEntity $role)
    {
        $role->delete();

        return response()->noContent();
    }
}
