<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\SiteLogbook;
use Modules\ForestResources\Http\Requests\CreateSiteLogbookRequest;
use Modules\ForestResources\Http\Requests\UpdateSiteLogbookRequest;
use ShapeFile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Modules\ForestResources\Services\SiteLogbook as SiteLogbookService;
use Shapefile\Geometry\Polygon;
use Illuminate\Support\Facades\File;

class SiteLogbookController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, SiteLogbook::class,['AnnualAllowableCut'],['items','logs','concession','developmentunit','managementunit','anuualallowablecut']));
    }

    /**
     * Store sitelogbook
     * @param CreateSiteLogbookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSiteLogbookRequest $request)
    {

        $data = $request->validated();

        $sitelogbook = SiteLogbook::create($data);

        return response()->json([
            'message' => lang("sitelogbook_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SiteLogbook $sitelogbook)
    {
        return response()->json(['data' => $sitelogbook]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SiteLogbook $sitelogbook
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSiteLogbookRequest $request, SiteLogbook $sitelogbook)
    {

        $data = $request->validated();

        $sitelogbook->update($data);

        return response()->json([
            'message' => lang('sitelogbook_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(SiteLogbook $sitelogbook)
    {
        $sitelogbook->delete();

        return response()->json([
            'message' => lang('sitelogbook_delete_successful')
        ], 204);
    }


}
