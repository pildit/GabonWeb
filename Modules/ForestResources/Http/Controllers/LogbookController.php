<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\Logbook;
use Modules\ForestResources\Http\Requests\CreateLogbookRequest;
use Modules\ForestResources\Http\Requests\UpdateLogbookRequest;
use Modules\ForestResources\Services\Logbook as LogbookService;
use App\Traits\Approve;


class LogbookController extends Controller
{
    use Approve;

    private $modelName = Logbook::class;

    public function __construct()
    {
        $this->middleware('can:logbook.view')->only('index', 'show');

        $this->middleware('can:logbook.add')->only('store');

        $this->middleware('can:logbook.edit')->only('update');

        $this->middleware('can:logbook.approve')->only('approve');

        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, Logbook::class,['AnnualAllowableCut'],['anuualallowablecut']));
    }

    /**
     * Store logbook
     * @param CreateLogbookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLogbookRequest $request)
    {

        $data = $request->validated();

        $logbook = Logbook::create($data);

        return response()->json([
            'message' => lang("logbook_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Logbook $logbook)
    {
        $logbook['items'] = $logbook->items()->get();
        return response()->json(['data' => $logbook]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Logbook $logbook
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLogbookRequest $request, Logbook $logbook)
    {

        $data = $request->validated();

        $logbook->update($data);

        return response()->json([
            'message' => lang('logbook_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Logbook $logbook)
    {
        $logbook->delete();

        return response()->json([
            'message' => lang('logbook_delete_successful')
        ], 204);

    }

    /**
     * @param LogbookService $logbookService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(LogbookService $logbookService)
    {
        $form = $logbookService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }


}
