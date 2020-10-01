<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\PageRole;
use Modules\Admin\Entities\Role;
use Modules\Admin\Http\Requests\PermissionRequest;
use Modules\Admin\Services\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request, Permission $permissionService)
    {
        $permissionService->validateRequest($request);
        $permissionService->setPage($request->get('page'));
        $permissionService->setPerPage($request->get('per_page'));
        $permissionService->setSearch($request->get('search'));

        return response()->json($permissionService->getPaginator());
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PermissionRequest $request)
    {
        DB::beginTransaction();

        try {

            $page = Page::find($request->get('page_id'));
            $role = Role::find($request->get('role_id'));

            PageRole::create([
                'page_id' => $request->get('page_id'), 'role_id' => $request->get('role_id')
            ]);

            foreach ($request->get('can') as $item) {
                $permission = new \Modules\Admin\Entities\Permission();
                $permission->name = $page->resource.".".$item;
                $permission->save();
                $permission->assignRole($role);
            }


            DB::commit();
            return response()->json([
                'data' => [],
                'message' => 'success'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
