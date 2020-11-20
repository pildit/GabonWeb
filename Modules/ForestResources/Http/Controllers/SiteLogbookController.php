<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\SiteLogbook;
use Modules\ForestResources\Http\Requests\CreateSiteLogbookRequest;
use Modules\ForestResources\Http\Requests\UpdateSiteLogbookRequest;
use Modules\ForestResources\Services\Logbook as LogbookService;
use ShapeFile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Modules\ForestResources\Services\SiteLogbook as SiteLogbookService;
use Shapefile\Geometry\Polygon;
use Illuminate\Support\Facades\File;
use App\Traits\Approve;

class SiteLogbookController extends Controller
{

    use Approve;

    private $modelName = SiteLogbook::class;

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

        return response()->json($pr->getPaginator($request, SiteLogbook::class,['AnnualAllowableCut'],['anuualallowablecut']));
    }

    /**
     * Store site_logbook
     * @param CreateSiteLogbookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSiteLogbookRequest $request)
    {

        $data = $request->validated();

        $site_logbook = SiteLogbook::create($data);

        return response()->json([
            'message' => lang("site_logbook_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SiteLogbook $site_logbook)
    {
        return response()->json(['data' => $site_logbook]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SiteLogbook $site_logbook
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSiteLogbookRequest $request, SiteLogbook $site_logbook)
    {

        $data = $request->validated();

        $site_logbook->update($data);

        return response()->json([
            'message' => lang('site_logbook_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(SiteLogbook $site_logbook)
    {
        $site_logbook->delete();

        return response()->json([
            'message' => lang('site_logbook_delete_successful')
        ], 204);
    }

    /**
     * @param SiteLogbookService $site_logbookService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(SiteLogbookService $site_logbookService)
    {
        $form = $site_logbookService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }


}
