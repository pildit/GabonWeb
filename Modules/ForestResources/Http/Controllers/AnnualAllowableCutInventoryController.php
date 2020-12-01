<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Entities\AnnualAllowableCutInventory;
use Modules\ForestResources\Entities\Parcel;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateAnnualAllowableCutInventoryRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualAllowableCutInventoryRequest;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Services\AnnualAllowableCutInventory as AnnualAllowableCutInventoryService;
use App\Traits\Approve;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class AnnualAllowableCutInventoryController extends Controller
{
    use Approve;

    private $modelName = AnnualAllowableCutInventory::class;

    public function __construct()
    {
        $this->middleware('permission:AACInventory.view')->only('index', 'show');

        $this->middleware('permission:AACInventory.add')->only('store');

        $this->middleware('permission:AACInventory.edit')->only('update');

        $this->middleware('permission:AACInventory.approve')->only('approve');

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param PageResults $pr
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, AnnualAllowableCutInventory::class, ['annual_allowable_cut.Name', 'MobileId'], ['annual_allowable_cut']));
    }

    /**
     * Store annual_allowable_cut_inventory
     * @param CreateAnnualAllowableCutInventoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnualAllowableCutInventoryRequest $request)
    {
        $data = $request->validated();

        $srid = config('forestresources.srid');
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lat']}, {$data['Lon']}),4326),$srid)";
        $data['Geometry'] = isset($data['Geometry']) ? DB::raw("public.st_geomfromtext('" . $data['Geometry'] . "', 5223)") : DB::raw("(select $geomQuery)");

        $AacId = AnnualAllowableCut::where("Id", $data['AnnualAllowableCut'])->value('AacId');
        if ($AacId) {
            $data['TreeId'] = $data['TreeId'] . "_" . $AacId;
        }

        $annual_allowable_cut_inventory = AnnualAllowableCutInventory::create($data);

        return response()->json([
            'message' => lang("annual_allowable_cut_inventory_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AnnualAllowableCutInventory $annual_allowable_cut_inventory)
    {
        return response()->json(['data' => $annual_allowable_cut_inventory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnualAllowableCutInventoryRequest $request
     * @param AnnualAllowableCutInventory $annual_allowable_cut_inventory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnualAllowableCutInventoryRequest $request, AnnualAllowableCutInventory $annual_allowable_cut_inventory)
    {
        $data = $request->validated();

        $srid = config('forestresources.srid');
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lat']}, {$data['Lon']}),4326),$srid)";
        $data['Geometry'] = isset($data['Geometry']) ? DB::raw("public.st_geomfromtext('" . $data['Geometry'] . "', 5223)") : DB::raw("(select $geomQuery)");

        $annual_allowable_cut_inventory->update($data);

        return response()->json([
            'message' => lang('annual_allowable_cut_inventory_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AnnualAllowableCutInventory $annual_allowable_cut_inventory)
    {
        $annual_allowable_cut_inventory->delete();

        return response()->json([
            'message' => lang('annual_allowable_cut_inventory_delete_successful')
        ], 204);


    }


    /**
     * @param AnnualAllowableCutInventoryService $aaciService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(AnnualAllowableCutInventoryService $aaciService)
    {
        $form = $aaciService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }

    /**
     * @param Request $request
     * @param AnnualAllowableCutInventoryService $aaciService
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, AnnualAllowableCutInventoryService $aaciService)
    {
        $request->validate(
            [
                'bbox' => 'string',
                'Id' => 'nullable|exists:Modules\ForestResources\Entities\AnnualAllowableCutInventory,Id'
            ]
        );

        return response()->json([
            'type' => 'FeatureCollection',
            'name' => 'annual_allowable_cut_inventory',
            'features' => $aaciService->getVectors($request->get('bbox', config('forestresources.default_bbox')),$request->get('Id'))
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

        $headings = ['AnnualAllowableCut', 'Species', 'Quality', 'Parcel', 'TreeId', 'DiameterBreastHeight', 'Lat', 'Lon', 'GpsAccu'];
        $collection = AnnualAllowableCutInventory::select('Id', 'AnnualAllowableCut', 'Species', 'Quality', 'Parcel', 'TreeId', 'DiameterBreastHeight', 'Lat', 'Lon', 'GpsAccu')->take(1000);

        if ($request->get('date_from')) {
            $collection = $collection->where("CreatedAt", ">=", $request->get('date_from'));
        }
        if ($request->get('date_to')) {
            $collection = $collection->where("CreatedAt", "<=", $request->get('date_to'));
        }
        $collection = $collection->get();

        $collection = $collection->map(function ($item) {

            $AnnualAllowableCut = (AnnualAllowableCut::select("Name")->where("Id", $item->AnnualAllowableCut)->first()) ?
                AnnualAllowableCut::select("Name")->where("Id", $item->AnnualAllowableCut)->first()->Name :
                $item->AnnualAllowableCut;

            $Species = (Species::select("CommonName")->where("Id", $item->Species)->first()) ?
                Species::select("CommonName")->where("Id", $item->Species)->first()->CommonName :
                $item->Species;

            $Parcel = (Parcel::select("Name")->where("Id", $item->Parcel)->first()) ?
                Parcel::select("Name")->where("Id", $item->Parcel)->first()->Name :
                $item->Parcel;

            return [
                'AnnualAllowableCut' => $AnnualAllowableCut,
                'Species' => $Species,
                'Quality' => $item->Quality,
                'Parcel' => $Parcel,
                'TreeId' => $item->TreeId,
                'DiameterBreastHeight' => $item->DiameterBreastHeight,
                'Lat' => $item->Lat,
                'Lon' => $item->Lon,
                'GpsAccu' => $item->GpsAccu
            ];
        });

        return Excel::download(new Exporter($collection, $headings), 'annual_allowable_cut_inventory.xlsx');
    }

}
