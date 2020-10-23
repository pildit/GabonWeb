<?php

namespace Modules\Transport\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Permit;
use Modules\Transport\Entities\Item as ItemEntity;

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
    public function index($permit, Request $request, PageResults $pageResults)
    {
        return response()->json(
            $pageResults
                ->setWhere(["mobile_id" => $permit, "permit_id" => (int)$permit])
                ->getPaginator(
                    $request,
                    ItemEntity::class ,
                    [
                        "trunk_number",
                        "lot_number",
                        "species"
                    ]
                ));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store($permit, CreatePermitItemRequest $request)
    {
        $permit = Permit::where('id', (int)$permit)->orWhere('mobile_id', $permit)->firstOrFail();

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

        return response()->json([
            "data" => $form
        ]);
    }
}
