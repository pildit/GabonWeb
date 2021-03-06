<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\SiteLogbookItem;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateSiteLogbookItemRequest;
use Modules\ForestResources\Http\Requests\UpdateSiteLogbookItemRequest;
use Modules\ForestResources\Services\SiteLogbookItem as SiteLogbookItemService;
use Modules\ForestResources\Entities\SiteLogbook;
use Illuminate\Validation\ValidationException;
use App\Traits\Approve;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class SiteLogbookItemController extends Controller
{

    use Approve;

    private $modelName = SiteLogbookItem::class;

    public function __construct()
    {
        $this->middleware('permission:site_logbook.view')->only('index', 'show');
        $this->middleware('permission:site_logbook.add|site_logbook.sync')->only('store');
        $this->middleware('permission:site_logbook.edit')->only('update');
        $this->middleware('permission:site_logbook.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, PageResults $pr,$SiteLogbook)
    {
        $pr->setSortFields(['Id']);
        if(!$SiteLogbook){
            throw ValidationException::withMessages(['ManagementUnit' => 'validation.exists']);
        }
        $pr->setWhere(['SiteLogbook' => $SiteLogbook]);

        return response()->json(
            $pr->getPaginator($request, SiteLogbookItem::class,[
                'HewingId', 'Length', 'AverageDiameter', 'Volume', 'SpeciesLatinName', 'SpeciesCommonName'
            ],['logs'])
        );
    }

    /**
     * Store site_logbook_item
     * @param CreateSiteLogbookItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSiteLogbookItemRequest $request)
    {

        $data = $request->validated();
        $sitelogbook = is_int($data['SiteLogbook']) ?
            SiteLogbook::where('Id', (int)$data['SiteLogbook'])->orWhere('MobileId', $data['SiteLogbook'])->first():
            SiteLogbook::where('MobileId', $data['SiteLogbook'])->first();
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
            $sitelogbook = is_int($data['SiteLogbook']) ?
                SiteLogbook::where('Id', (int)$data['SiteLogbook'])->orWhere('MobileId', $data['SiteLogbook'])->first():
                SiteLogbook::where('MobileId', $data['SiteLogbook'])->first();
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ['SiteLogbook','Species','HewingId','Date','MaxDiameter','MinDiameter','AverageDiameter','Length','Volume','ObserveAt','Approved'];
        $collection = SiteLogbookItem::select('Id','SiteLogbook','Species','HewingId','Date','MaxDiameter','MinDiameter','AverageDiameter','Length','Volume','ObserveAt');

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
                'SiteLogbook'=> $item->SiteLogbook,
                'Species'=> $Species,
                'HewingId'=> $item->HewingId,
                'Date'=> $item->Date,
                'MaxDiameter'=> $item->MaxDiameter,
                'MinDiameter'=> $item->MinDiameter,
                'AverageDiameter'=> $item->AverageDiameter,
                'Length'=> $item->Length,
                'Volume'=> $item->Volume,
                'ObserveAt'=> $item->ObserveAt
            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'sitelogbook_item.xlsx');
    }
}
