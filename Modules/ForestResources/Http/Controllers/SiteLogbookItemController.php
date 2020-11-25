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
use App\Traits\Approve;

class SiteLogbookItemController extends Controller
{

    use Approve;

    private $modelName = SiteLogbookItem::class;

    public function __construct()
    {
        $this->middleware('permission:site_logbook.view')->only('index', 'show');

        $this->middleware('permission:site_logbook.add')->only('store');

        $this->middleware('permission:site_logbook.edit')->only('update');

        $this->middleware('permission:site_logbook.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);
        $sitelogbook = SiteLogbook::where('Id', (int)$request->get("SiteLogbook"))->first();
        if(!$sitelogbook){
            throw ValidationException::withMessages(['SiteLogbook' => 'validation.exists']);
        }
        $request->merge(['search'=>$request->get("SiteLogbook")]);
        return response()->json($pr->getPaginator($request, SiteLogbookItem::class,['SiteLogbook'],['logs']));
    }

    /**
     * Store site_logbook_item
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
        $site_logbook_item = SiteLogbookItem::create($data);

        return response()->json([
            'message' => lang("site_logbook_item_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SiteLogbookItem $site_logbook_item)
    {
        $site_logbook_item['family'] = $site_logbook_item->family()->get();
        return response()->json(['data' => $site_logbook_item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SiteLogbookItem $site_logbook_item
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSiteLogbookItemRequest $request, SiteLogbookItem $site_logbook_item)
    {

        $data = $request->validated();
        if(isset($data['SiteLogbook'])){
            $sitelogbook = SiteLogbook::where('Id', (int)$data['SiteLogbook'])->orWhere('MobileId', $data['SiteLogbook'])->first();
            if(!$sitelogbook){
                throw ValidationException::withMessages(['SiteLogbook' => 'validation.exists']);
            }
            $data['SiteLogbook'] = $sitelogbook->Id;
        }

        $site_logbook_item->update($data);

        return response()->json([
            'message' => lang('site_logbook_item_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(SiteLogbookItem $site_logbook_item)
    {
        $site_logbook_item->delete();

        return response()->json([
            'message' => lang('site_logbook_item_delete_successful')
        ], 204);
    }

    /**
     * @param SiteLogbookItemService $site_logbook_itemService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(SiteLogbookItemService $site_logbook_itemService)
    {
        $form = $site_logbook_itemService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }
}
