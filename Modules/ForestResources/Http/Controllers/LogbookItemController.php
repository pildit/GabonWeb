<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use App\Traits\Approve;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\LogbookItem;
use Modules\ForestResources\Http\Requests\CreateLogbookItemRequest;
use Modules\ForestResources\Http\Requests\UpdateLogbookItemRequest;
use Modules\ForestResources\Services\Logbook as LogbookService;
use Modules\ForestResources\Services\LogbookItem as LogbookItemService;
use Modules\ForestResources\Entities\Logbook;
use Illuminate\Validation\ValidationException;

class LogbookItemController extends Controller
{
    use Approve;

    private $modelName = LogbookItem::class;

    public function __construct()
    {
        $this->middleware('can:carnet-abattage.view')->only('index', 'show');

        $this->middleware('can:carnet-abattage.add')->only('store');

        $this->middleware('can:carnet-abattage.edit')->only('update');

        $this->middleware('can:carnet-abattage.approve')->only('approve');

        $this->middleware('role:admin')->only('delete');

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
        $logbook = Logbook::where('Id', (int)$data['Logbook'])->orWhere('MobileId', $data['Logbook'])->first();
        if(!$logbook){
            throw ValidationException::withMessages(['Logbook' => 'validation.exists']);
        }
        $data['Logbook'] = $logbook->Id;
        $logbook_item = LogbookItem::create($data);

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
            $logbook = Logbook::where('Id', (int)$data['Logbook'])->orWhere('MobileId', $data['Logbook'])->first();
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

}
