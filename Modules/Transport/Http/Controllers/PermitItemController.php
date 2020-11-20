<?php

namespace Modules\Transport\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Entities\Item as ItemEntity;
use Modules\Transport\Http\Requests\CreatePermitItemRequest;
use Modules\Transport\Http\Requests\UpdatePermitItemRequest;
use Modules\Transport\Services\Item;

class PermitItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permit.view')->only('index', 'show');

        $this->middleware('can:permit.add')->only('store');

        $this->middleware('can:permit.edit')->only('update');

        $this->middleware('role:admin')->only('delete');

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

        return response()->json($pr->getPaginator($request, ItemEntity::class, ["Permit"]));

    }

    /**
     * Save permit item
     * @param CreatePermitItemRequest $request
     * @return JsonResponse
     */

    public function store(CreatePermitItemRequest $request)
    {
        $data = $request->validated();

        $permit = PermitEntity::where('Id', (int)$data['Permit'])->orWhere('MobileId', $data['Permit'])->first();
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
            $permit = PermitEntity::where('Id', (int)$data['Permit'])->orWhere('MobileId', $data['Permit'])->first();
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
}
