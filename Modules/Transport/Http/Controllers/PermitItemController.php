<?php

namespace Modules\Transport\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\ForestResources\Entities\Species;
use Modules\Transport\Entities\Permit;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Entities\Item as ItemEntity;
use Modules\Transport\Http\Requests\CreatePermitItemRequest;
use Modules\Transport\Http\Requests\UpdatePermitItemRequest;
use Modules\Transport\Services\Item;
use Modules\Transport\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class PermitItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permit.view')->only('index', 'show');
        $this->middleware('permission:permit.add|permit.sync')->only('store');
        $this->middleware('permission:permit.edit')->only('update');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Return a list of permit items for a specific permit
     * @param Request $request
     * @param PageResults $pr
     * @return JsonResponse
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);
        $permit = PermitEntity::where('Id', (int)$request->get("Permit"))->first();
        if(!$permit){
            throw ValidationException::withMessages(['Permit' => 'validation.exists']);
        }
        $request->merge(['search'=>$request->get("Permit")]);

        return response()->json($pr->getPaginator($request, ItemEntity::class, ["Permit"], ['species']));

    }

    /**
     * Save permit item
     * @param CreatePermitItemRequest $request
     * @return JsonResponse
     */

    public function store(CreatePermitItemRequest $request)
    {
        $data = $request->validated();

        $permit = is_int($data['Permit']) ?
            PermitEntity::where('Id', (int)$data['Permit'])->orWhere('MobileId', $data['Permit'])->first() :
            PermitEntity::where('MobileId', $data['Permit'])->first();

        if(!$permit){
            throw ValidationException::withMessages(['Permit' => 'validation.exists']);
        }
        $data['Permit'] = $permit->Id;
        $item = ItemEntity::create($data);

        return response()->json([
            'message' => lang("permititem_created_successfully")
        ], 201);
    }

    /**
     * Update permit item
     * @param ItemEntity $item
     * @param CreatePermitItemRequest $request
     * @return JsonResponse
     */

    public function update(ItemEntity $item, UpdatePermitItemRequest $request)
    {
        $data = $request->validated();
        if(isset($data['Permit'])){
            $permit = is_int($data['Permit']) ?
                PermitEntity::where('Id', (int)$data['Permit'])->orWhere('MobileId', $data['Permit'])->first() :
                PermitEntity::where('MobileId', $data['Permit'])->first();
            if(!$permit){
                throw \ValidationException::withMessages(['Permit' => 'validation.exists']);
            }
            $data['Permit'] = $permit->Id;
        }
        $item->update($data);

        return response()->json([
            'message' => lang('permititem_update_successful')
        ], 200);
    }


    /**
     * Soft Delete Permit Item
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permit = ItemEntity::findOrFail($id);

        $permit->delete();

        return response()->json([
            'message' => lang('permititem_delete_successful')
        ], 204);
    }


    /**
     * Get mobile form
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ["Permit", "LogId", "Species", "MinDiameter", "MaxDiameter", "AverageDiameter", "Length", "Volume"];
        $collection = ItemEntity::select("Id","Permit", "LogId", "Species", "MinDiameter", "MaxDiameter", "AverageDiameter", "Length", "Volume");

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

            $Permit = (Permit::select("PermitNo")->where("Id", $item->Permit)->first()) ?
                Permit::select("PermitNo")->where("Id", $item->Permit)->first()->PermitNo :
                $item->Permit;

            return [
                "Permit"=>$Permit,
                "LogId"=>$item->LogId,
                "Species"=>$Species,
                "MinDiameter"=>$item->MinDiameter,
                "MaxDiameter"=>$item->MaxDiameter,
                "AverageDiameter"=>$item->AverageDiameter,
                "Length"=>$item->Length,
                "Volume"=>$item->Volume,

            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'permit_item.xlsx');
    }
}
