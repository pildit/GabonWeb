<?php

namespace Modules\Transport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Permit;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return view('transport::show');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        //
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
