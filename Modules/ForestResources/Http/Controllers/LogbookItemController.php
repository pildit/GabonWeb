<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use App\Traits\Approve;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\LogbookItem;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateLogbookItemRequest;
use Modules\ForestResources\Http\Requests\UpdateLogbookItemRequest;
use Modules\ForestResources\Services\Logbook as LogbookService;
use Modules\ForestResources\Services\LogbookItem as LogbookItemService;
use Modules\ForestResources\Entities\Logbook;
use Illuminate\Validation\ValidationException;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class LogbookItemController extends Controller
{
    use Approve;

    private $modelName = LogbookItem::class;

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
        $logbook = Logbook::where('Id', (int)$request->get("Logbook"))->first();
        if(!$logbook){
            throw ValidationException::withMessages(['Logbook' => 'validation.exists']);
        }
        $request->merge(['search'=>$request->get("Logbook")]);

        return response()->json($pr->getPaginator($request, LogbookItem::class,['Logbook']));
    }

    /**
     * Store logbook_item
     * @param CreateLogbookItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(CreateLogbookItemRequest $request)
    {

        $data = $request->validated();

        $logbook = Logbook::where('LogBookName', $data['LogBookName'])->first();

        $data['Logbook'] = $logbook->Id;
        $logbook_item = LogbookItem::where('Logbook', $logbook->Id)->where('HewingId', $data['HewingId'])->first();

        if($logbook_item !== null) {
            LogbookItem::where('Id', $logbook_item->Id)->update($data);
        } else {
            LogbookItem::create($data);
        }

        return response()->json([
            'message' => lang("logbook_item_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LogbookItem $logbook_item)
    {
        return response()->json(['data' => $logbook_item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  LogbookItem $logbook_item
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLogbookItemRequest $request, LogbookItem $logbook_item)
    {
        $data = $request->validated();
        if(isset($data['Logbook'])){
            $logbook = is_int($data['Logbook']) ?
                Logbook::where('Id', (int)$data['Logbook'])->orWhere('MobileId', $data['Logbook'])->first():
                Logbook::where('MobileId', $data['Logbook'])->first();
            if(!$logbook){
                throw ValidationException::withMessages(['Logbook' => 'validation.exists']);
            }
            $data['Logbook'] = $logbook->Id;
        }
        $logbook_item->update($data);

        return response()->json([
            'message' => lang('logbook_item_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(LogbookItem $logbook_item)
    {
        $logbook_item->delete();

        return response()->json([
            'message' => lang('logbook_item_delete_successful')
        ], 204);
    }

    /**
     * @param LogbookService $logbook_itemService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(LogbookItemService $logbook_itemService)
    {
        $form = $logbook_itemService->getMobileForm();

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

        $headings  = ['Logbook','TreeId','HewingId','Species','MaxDiameter','MinDiameter','Length','Volume','Lat','Lon','GpsAccu','Note','ObserveAt'];
        $collection = LogbookItem::select('Id', 'Logbook','TreeId','HewingId','Species','MaxDiameter','MinDiameter','Length','Volume','Lat','Lon','GpsAccu','Note','ObserveAt');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();
        $collection = $collection->map(function ($item) {

            $Species = (Species::select("CommonName")->where("Id", $item->Species)->first()) ?
                Species::select("CommonName")->where("Id", $item->Species)->first()->CommonName :
                $item->Species;

            return [
                'Logbook'=> $item->Logbook,
                'TreeId'=> $item->TreeId,
                'HewingId'=> $item->HewingId,
                'Species'=> $Species,
                'MaxDiameter'=> $item->MaxDiameter,
                'MinDiameter'=> $item->MinDiameter,
                'Length'=> $item->Length,
                'Volume'=> $item->Volume,
                'Lat'=> $item->Lat,
                'Lon'=> $item->Lon,
                'GpsAccu'=> $item->GpsAccu,
                'Note'=> $item->Note,
                'ObserveAt'=> $item->ObserveAt
            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'logbook_item.xlsx');
    }
}
