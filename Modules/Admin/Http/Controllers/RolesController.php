<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\PageResults;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Role as RoleEntity;
use Modules\Admin\Services\Role;

class RolesController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
    //    $this->middleware('permission:role.add')->only('store');

    //    $this->middleware('permission:role.edit')->only('update');

//        $this->middleware('role:admin');

    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request, PageResults $pageResults)
    {
        return response()->json($pageResults->getPaginator($request, RoleEntity::class , ['name']));
    }

    /**
     * @return JsonResponse
     */
    public function listRoles()
    {
        $roles = RoleEntity::all();
        return response()->json([
            "data" => $roles->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:Modules\Admin\Entities\Role,name',
            'type' => 'integer',
            'permissions' => 'required',
            'permissions.*' => 'integer|exists:Modules\Admin\Entities\Permission,id'
        ]);

        $role = new RoleEntity();
        $role->name = $data['name'];
        $role->type = $data['type'];
        $role->save();
        $role->syncPermissions($data['permissions']);

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
            "data" => $role->fresh(['permissions' => function($q) {
                $q->select('name', 'id');
            }])
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
            'name' => 'string|unique:Modules\Admin\Entities\Role,name,'.$role->id,
            'type' => 'integer',
            'permissions' => 'required',
            'permissions.*' => 'integer|exists:Modules\Admin\Entities\Permission,id'
        ]);

        $role->update($data);
        $role->syncPermissions($data['permissions']);

        return response()->json([
            'data' => $role->fresh(['permissions'])
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
