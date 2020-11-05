<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\SiteLogbookLog;
use Modules\ForestResources\Http\Requests\CreateSiteLogbookLogRequest;
use Modules\ForestResources\Http\Requests\UpdateSiteLogbookLogRequest;
use Modules\ForestResources\Services\SiteLogbookItem as SiteLogbookItemService;
use ShapeFile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Modules\ForestResources\Services\SiteLogbookLog as SiteLogbookLogService;
use Shapefile\Geometry\Polygon;
use Illuminate\Support\Facades\File;

class SiteLogbookLogController extends Controller
{
    /**
     * Store sitelogbooklog
     * @param CreateSiteLogbookLogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSiteLogbookLogRequest $request)
    {

        $data = $request->validated();

        $sitelogbooklog = SiteLogbookLog::create($data);

        return response()->json([
            'message' => lang("sitelogbooklog_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SiteLogbookLog $sitelogbooklog)
    {
        return response()->json(['data' => $sitelogbooklog]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SiteLogbookLog $sitelogbooklog
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSiteLogbookLogRequest $request, SiteLogbookLog $sitelogbooklog)
    {

        $data = $request->validated();

        $sitelogbooklog->update($data);

        return response()->json([
            'message' => lang('sitelogbooklog_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(SiteLogbookLog $sitelogbooklog)
    {
        $sitelogbooklog->delete();

        return response()->json([
            'message' => lang('sitelogbooklog_delete_successful')
        ], 204);
    }


    /**
     * @param SiteLogbookLogService $sitelogbooklogService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(SiteLogbookLogService $sitelogbooklogService)
    {
        $form = $sitelogbooklogService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }
}
