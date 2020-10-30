<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\LogbookItem;
use Modules\ForestResources\Http\Requests\CreateLogbookItemRequest;
use Modules\ForestResources\Http\Requests\UpdateLogbookItemRequest;


class LogbookItemController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, LogbookItem::class,[]));
    }

    /**
     * Store logbookitem
     * @param CreateLogbookItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLogbookItemRequest $request)
    {

        $data = $request->validated();

        $logbookitem = LogbookItem::create($data);

        return response()->json([
            'message' => lang("logbookitem_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LogbookItem $logbookitem)
    {
        return response()->json(['data' => $logbookitem]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  LogbookItem $logbookitem
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLogbookItemRequest $request, LogbookItem $logbookitem)
    {

        $data = $request->validated();

        $logbookitem->update($data);

        return response()->json([
            'message' => lang('logbookitem_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(LogbookItem $logbookitem)
    {
        $logbookitem->delete();

        return response()->json([
            'message' => lang('logbookitem_delete_successful')
        ], 204);
    }


}
