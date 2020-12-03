<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Entities\ManagementPlan;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Http\Requests\CreateAnnualAllowableCutRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualAllowableCutRequest;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Services\AnnualAllowableCut as AnnualAllowableCutService;
use Log;
use App\Traits\Approve;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class AnnualAllowableCutController extends Controller
{

    use Approve;

    private $modelName = AnnualAllowableCut::class;

    public function __construct()
    {
        $this->middleware('permission:AAC.view')->only('index', 'show');
        $this->middleware('permission:AAC.add|AAC.sync')->only('store');
        $this->middleware('permission:AAC.edit')->only('update');
        $this->middleware('permission:AAC.approve')->only('approve');

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param AnnualAllowableCutService $annual_allowable_cutService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request, PageResults $pr)
    {

        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, AnnualAllowableCut::class , [ 'Name'], ['management_unit:Id,Name']));
    }

    /**
     * Store annual_allowable_cut
     * @param CreateAnnualAllowableCutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnualAllowableCutRequest $request)
    {
        $data = $request->validated();

        $AacIdName =  date("y")."_".strtoupper(substr($data['Name'], 0, 3));
        $aacNumber = DB::table('ForestResources.AnnualAllowableCuts')
            ->where('AacId','ilike', $AacIdName."%")
            ->count();

        $data['ProductType'] = $data['ProductType'] ?? "1";

        $aacNumber = sprintf("%03d", ++$aacNumber);
        $data['AacId'] = $AacIdName."_".$aacNumber;

        $annual_allowable_cut = AnnualAllowableCut::create($data);

        return response()->json([
            'message' => lang("annual_allowable_cut_created_successfully"),
            'id' => $annual_allowable_cut->Id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AnnualAllowableCut $annual_allowable_cut)
    {
        $annual_allowable_cut->load('annualoperation_plans');
        return response()->json(['data' => $annual_allowable_cut]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnualAllowableCutRequest $request
     * @param AnnualAllowableCut $annual_allowable_cut
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnualAllowableCutRequest $request, AnnualAllowableCut $annual_allowable_cut)
    {
        $data = $request->validated();

        $annual_allowable_cut->update($data);

        return response()->json([
            'message' => lang('annual_allowable_cut_update_successful')
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AnnualAllowableCut $annual_allowable_cut)
    {
        $annual_allowable_cut->delete();

        return response()->json([
            'message' => lang('annual_allowable_cut_delete_successful')
        ], 204);

    }

    /**
     * @param Request $request
     * @param AnnualAllowableCutService $aacService
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, AnnualAllowableCutService $aacService)
    {
        $request->validate([
            'bbox' => 'string',
            'Name' => 'nullable|string',
            'Id' => 'nullable|exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            'AacId' => 'nullable|string'
        ]);

        return response()->json([
            'type' => 'FeatureCollection',
            'name' => 'annual_allowable_cut',
            'features' => $aacService->getVectors($request->get('bbox', config('forestresources.default_bbox')),$request->get('Name'),$request->get('AacId'),$request->get('Id'))
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

        $headings  = ['Name','AacId','ManagementUnit','ManagementPlan'];
        $collection = AnnualAllowableCut::select('Id', 'Name','AacId','ManagementUnit','ManagementPlan');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }
        $collection = $collection->get();

        $collection = $collection->map(function ($item) {

            $ManagementUnit = (ManagementUnit::select("Name")->where("Id",$item->ManagementUnit)->first()) ?
                ManagementUnit::select("Name")->where("Id",$item->ManagementUnit)->first()->Name  :
                $item->ManagementUnit;

            return [
                'Name' => $item->Name,
                'ID' => $item->AacId,
                'ManagementUnit' => $ManagementUnit,
                'ManagementPlan' => $item->ManagementPlan
            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'annual_allowable_cut.xlsx');
    }

}
