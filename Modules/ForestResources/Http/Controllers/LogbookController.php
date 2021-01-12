<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Entities\Concession;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\Logbook;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Http\Requests\CreateLogbookRequest;
use Modules\ForestResources\Http\Requests\UpdateLogbookRequest;
use Modules\ForestResources\Services\Logbook as LogbookService;
use App\Traits\Approve;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class LogbookController extends Controller
{
    use Approve;

    private $modelName = Logbook::class;

    public function __construct()
    {
        $this->middleware('permission:logbook.view')->only('index', 'show');
        $this->middleware('permission:logbook.add|logbook.sync')->only('store');
        $this->middleware('permission:logbook.edit')->only('update');
        $this->middleware('permission:logbook.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, Logbook::class,['ConcessionName','AnnualAllowableCutName'],['anuualallowablecut', 'concession']));
    }

    /**
     * Store logbook
     * @param CreateLogbookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLogbookRequest $request)
    {

        $data = $request->validated();
        /**
         *
         * 0 - Concession
         * 1 - DevelopmentUnit
         * 2 - ManagementUnit
         * 3 - AnualAllowableCut
         *
         */
        $parts = explode('_', $request['LogBookName']);

        $logbook = Logbook::where( function ($query) use ($parts) {
            $query->where('Concession', $parts[0]);
            $query->where('DevelopmentUnit', $parts[1]);
            $query->where('ManagementUnit', $parts[2]);
            $query->where('AnualAllowableCut', $parts[3]);
        })->first();

        if($logbook !== null) {
            Logbook::where('Id', $logbook->Id)->update($data);
        } else {
            Logbook::create($data);
        }

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
        $logbook->load(['developmentunit', 'managementunit', 'items.species', 'concession', 'anuualallowablecut']);
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $logbook_table = (new Logbook())->getTable();
        $collection = app('db')->table($logbook_table)
            ->select('Id', 'ConcessionName','DevelopmentUnitName','ManagementUnitName','AnnualAllowableCutName','ObserveAt');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();

        return fastexcel($collection)->download('carnet_de_abattage.xlsx');
    }
}
