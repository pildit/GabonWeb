<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\PageRole;
use Modules\Admin\Entities\Permission as PermissionEntity;
use Modules\Admin\Entities\Role;
use Modules\Admin\Http\Requests\PermissionRequest;
use Modules\Admin\Services\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');

        $this->middleware('permission:permission.view')->only('index', 'show');


    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request, PageResults $pageResults)
    {
        return response()
            ->json(['data' => PermissionEntity::all()]);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PermissionRequest $request, Permission $permissionService)
    {
        $permissionService->storeTransaction($request);

        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * @param Role $role
     * @param Request $request
     * @return JsonResponse
     */
    public function permissions(Role $role, Request $request, Permission $permissionService)
    {
        $request->validate([
            'page_id' => 'required|exists:Modules\Admin\Entities\Page,id',
            'can' => 'required',
            'can.*' => ['required', Rule::in(PermissionEntity::$choices)]
        ]);

        $permissionService->updateTransaction($request, $role);

        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * @param Role $role
     */
    public function showPermissions(Role $role, Request $request, Permission $permissionService)
    {
        $permissionService->validateRequest($request);
        $permissionService->setPage($request->get('page'));
        $permissionService->setPerPage($request->get('per_page'));

        return $permissionService->getRolePagePaginator($role);
    }
}
