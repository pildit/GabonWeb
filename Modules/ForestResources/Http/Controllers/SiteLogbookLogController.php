<?php

namespace Modules\ForestResources\Http\Controllers;


use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\SiteLogbookLog;
use Modules\ForestResources\Http\Requests\CreateSiteLogbookLogRequest;
use Modules\ForestResources\Http\Requests\UpdateSiteLogbookLogRequest;
use Modules\ForestResources\Services\SiteLogbookLog as SiteLogbookLogService;
use Modules\ForestResources\Entities\SiteLogbookItem;
use Illuminate\Validation\ValidationException;

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
        $sitelogbookitem = SiteLogbookItem::where('Id', (int)$data['SiteLogbookItem'])->orWhere('MobileId', $data['SiteLogbookItem'])->first();
        if(!$sitelogbookitem){
            throw ValidationException::withMessages(['SiteLogbookItem' => 'validation.exists']);
        }
        $data['SiteLogbookItem'] = $sitelogbookitem->Id;
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
        if(isset($data['SiteLogbookItem'])){
            $sitelogbookitem = SiteLogbookItem::where('Id', (int)$data['SiteLogbookItem'])->orWhere('MobileId', $data['SiteLogbookItem'])->first();
            if(!$sitelogbookitem){
                throw ValidationException::withMessages(['SiteLogbookItem' => 'validation.exists']);
            }
            $data['SiteLogbookItem'] = $sitelogbookitem->Id;
        }

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
