<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Http\Requests\CreateAnnualAllowableCutRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualAllowableCutRequest;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Services\AnnualAllowableCut as AnnualAllowableCutService;
use Log;
use App\Traits\Approve;

class AnnualAllowableCutController extends Controller
{

    use Approve;

    private $modelName = AnnualAllowableCut::class;

    public function __construct()
    {
        $this->middleware('can:AAC.view')->only('index', 'show');

        $this->middleware('can:AAC.add')->only('store');

        $this->middleware('can:AAC.edit')->only('update');

        $this->middleware('can:AAC.approve')->only('approve');

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

        return response()->json($pr->getPaginator($request, AnnualAllowableCut::class , [ 'Name'], ['mangementunit','managementplan']));
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
            ->where('AacId','LIKE', $AacIdName."%")
            ->count();

        $aacNumber = sprintf("%03d", ++$aacNumber);
        $data['AacId'] = $AacIdName."_".$aacNumber;

        $annual_allowable_cut = AnnualAllowableCut::create($data);

        return response()->json([
            'message' => lang("annual_allowable_cut_created_successfully")
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
            'Name' => 'nullable|string'
        ]);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'annual_allowable_cut',
                'features' => $aacService->getVectors($request->get('bbox', config('forestresources.default_bbox')),$request->get('Name'))
            ]
        ]);
    }

}
