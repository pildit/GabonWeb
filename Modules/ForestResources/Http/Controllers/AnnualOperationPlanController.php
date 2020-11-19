<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualOperationPlan;
use Modules\ForestResources\Http\Requests\CreateAnnualOperationPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualOperationPlanRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\Approve;

class AnnualOperationPlanController extends Controller
{
    use Approve;

    private $modelName = AnnualOperationPlan::class;

    public function __construct()
    {
        $this->middleware('can:AAC.view')->only('index', 'show');

        $this->middleware('can:AAC.add')->only('store');

        $this->middleware('can:AAC.edit')->only('update');

        $this->middleware('can:AAC.approve')->only('approve');

    }

    /**
     * Store annualoperationplan
     * @param CreateAnnualOperationPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnualOperationPlanRequest $request)
    {
        $data = $request->validated();

        $annualoperationplan = AnnualOperationPlan::create($data);

        return response()->json([
            'message' => lang("annualoperationplan_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AnnualOperationPlan $annualoperationplan)
    {
        return response()->json(['data' => $annualoperationplan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnualOperationPlanRequest $request
     * @param AnnualOperationPlan $annualoperationplan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnualOperationPlanRequest $request, AnnualOperationPlan $annualoperationplan)
    {
        $data = $request->validated();
        $annualoperationplan->update($data);

        return response()->json([
            'message' => lang('annualoperationplan_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AnnualOperationPlan $annualoperationplan)
    {
        $annualoperationplan->delete();

        return response()->json([
            'message' => lang('annualoperationplan_delete_successful')
        ], 204);

    }


}
