<?php

namespace Modules\Transport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Permit;
use Modules\Transport\Http\Requests\CreatePermitItemRequest;
use Modules\Transport\Services\Item;

class PermitItemController extends Controller
{

    /**
     * Return a list of permit items for a specific permit
     *
     * @param Permit $permit
     * @return JsonResponse
     */
    public function index(Permit $permit, Request $request, Item $itemService)
    {
        $itemService->validateRequest($request);
        $itemService->setPage($request->get('page'));
        $itemService->setPerPage($request->get('per_page'));

        return response()->json($itemService->getPaginator());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Permit $permit, CreatePermitItemRequest $request)
    {
        $result = $permit->items()->save(new \Modules\Transport\Entities\Item($request->all()));

        return response()->json([
            "data" => $result
        ], 201);
    }

    /**
     * @param Item $itemService
     * @return JsonResponse
     */
    public function mobile(Item $itemService)
    {
        $form = $itemService->getMobileForm();

        return response()->json($form);
    }
}
