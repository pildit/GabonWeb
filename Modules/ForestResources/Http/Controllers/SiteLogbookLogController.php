<?php

namespace Modules\ForestResources\Http\Controllers;


use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\SiteLogbookLog;
use Modules\ForestResources\Http\Requests\CreateSiteLogbookLogRequest;
use Modules\ForestResources\Http\Requests\UpdateSiteLogbookLogRequest;
use Modules\ForestResources\Services\SiteLogbookLog as SiteLogbookLogService;
use Modules\ForestResources\Entities\SiteLogbookItem;
use Illuminate\Validation\ValidationException;
use App\Traits\Approve;

class SiteLogbookLogController extends Controller
{

    use Approve;

    private $modelName = SiteLogbookLog::class;

    public function __construct()
    {
        $this->middleware('permission:site_logbook.view')->only('index', 'show');

        $this->middleware('permission:site_logbook.add')->only('store');

        $this->middleware('permission:site_logbook.edit')->only('update');

        $this->middleware('permission:site_logbook.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * @param Request $request
     * @param PageResults $pr
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        $siteLogbookItem = SiteLogbookItem::where('Id', (int)$request->get("SiteLogbookItem"))->first();
        if(!$siteLogbookItem){
            throw ValidationException::withMessages(['SiteLogbook' => 'validation.exists']);
        }
        $request->merge(['search'=>$request->get("SiteLogbookItem")]);
        return response()->json($pr->getPaginator($request, SiteLogbookLog::class,['SiteLogbookItem'], ['species']));
    }

    /**
     * Store site_logbook_log
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
        $site_logbook_log = SiteLogbookLog::create($data);

        return response()->json([
            'message' => lang("site_logbook_log_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SiteLogbookLog $site_logbook_log)
    {
        return response()->json(['data' => $site_logbook_log]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SiteLogbookLog $site_logbook_log
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSiteLogbookLogRequest $request, SiteLogbookLog $site_logbook_log)
    {
        $data = $request->validated();
        if(isset($data['SiteLogbookItem'])){
            $sitelogbookitem = SiteLogbookItem::where('Id', (int)$data['SiteLogbookItem'])->orWhere('MobileId', $data['SiteLogbookItem'])->first();
            if(!$sitelogbookitem){
                throw ValidationException::withMessages(['SiteLogbookItem' => 'validation.exists']);
            }
            $data['SiteLogbookItem'] = $sitelogbookitem->Id;
        }

        $site_logbook_log->update($data);

        return response()->json([
            'message' => lang('site_logbook_log_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(SiteLogbookLog $site_logbook_log)
    {
        $site_logbook_log->delete();

        return response()->json([
            'message' => lang('site_logbook_log_delete_successful')
        ], 204);
    }


    /**
     * @param SiteLogbookLogService $site_logbook_logService
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile(SiteLogbookLogService $site_logbook_logService)
    {
        $form = $site_logbook_logService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }
}
