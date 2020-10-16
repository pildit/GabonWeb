<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Http\Requests\CreateAnnualAllowableCutRequest;
use Modules\ForestResources\Http\Requests\UpdateAnnualAllowableCutRequest;
use Modules\ForestResources\Services\AnnualAllowableCut as AnnualAllowableCutService;

class AnnualAllowableCutController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param AnnualAllowableCutService $annualallowablecutService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, AnnualAllowableCut::class , [ 'Name']));
    }

    /**
     * Store annualallowablecut
     * @param CreateAnnualAllowableCutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnualAllowableCutRequest $request)
    {
        $data = $request->validated();

        $annualallowablecut = AnnualAllowableCut::create($data);

        return response()->json([
            'message' => lang("annualallowablecut_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AnnualAllowableCut $annualallowablecut)
    {
        return response()->json(['data' => $annualallowablecut]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnualAllowableCutRequest $request
     * @param AnnualAllowableCut $annualallowablecut
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnualAllowableCutRequest $request, AnnualAllowableCut $annualallowablecut)
    {
        $data = $request->validated();

        $annualallowablecut->update($data);

        return response()->json([
            'message' => lang('annualallowablecut_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AnnualAllowableCut $annualallowablecut)
    {
        //$data['status'] = timestamp();
        //$annualallowablecut->fill($data);
        //$annualallowablecut->save($data);

    }


}
