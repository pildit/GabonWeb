<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\SiteLogbookItem;
use Modules\ForestResources\Http\Requests\CreateSiteLogbookItemRequest;
use Modules\ForestResources\Http\Requests\UpdateSiteLogbookItemRequest;
use Modules\ForestResources\Services\SiteLogbookItem as SiteLogbookItemService;
use Modules\ForestResources\Entities\SiteLogbook;
use Illuminate\Validation\ValidationException;

class SiteLogbookItemController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, SiteLogbookItem::class,[],['logs']));
    }

    /**
     * Store sitelogbookitem
     * @param CreateSiteLogbookItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSiteLogbookItemRequest $request)
    {

        $data = $request->validated();
        $sitelogbook = SiteLogbook::where('Id', (int)$data['SiteLogbook'])->orWhere('MobileId', $data['SiteLogbook'])->first();
        if(!$sitelogbook){
            throw ValidationException::withMessages(['SiteLogbook' => 'validation.exists']);
        }
        $data['SiteLogbook'] = $sitelogbook->Id;
        $sitelogbookitem = SiteLogbookItem::create($data);

        return response()->json([
            'message' => lang("sitelogbookitem_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SiteLogbookItem $sitelogbookitem)
    {
        return response()->json(['data' => $sitelogbookitem]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SiteLogbookItem $sitelogbookitem
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSiteLogbookItemRequest $request, SiteLogbookItem $sitelogbookitem)
    {

        $data = $request->validated();
        if(isset($data['SiteLogbook'])){
            $sitelogbook = SiteLogbook::where('Id', (int)$data['SiteLogbook'])->orWhere('MobileId', $data['SiteLogbook'])->first();
            if(!$sitelogbook){
                throw ValidationException::withMessages(['SiteLogbook' => 'validation.exists']);
            }
            $data['SiteLogbook'] = $sitelogbook->Id;
        }

        $sitelogbookitem->update($data);

        return response()->json([
            'message' => lang('sitelogbookitem_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(SiteLogbookItem $sitelogbookitem)
    {
        $sitelogbookitem->delete();

        return response()->json([
            'message' => lang('sitelogbookitem_delete_successful')
        ], 204);
    }

    /**
     * @param SiteLogbookItemService $sitelogbookitemService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(SiteLogbookItemService $sitelogbookitemService)
    {
        $form = $sitelogbookitemService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }
}
