<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\Concession;
use App\Services\PageResults;
use Modules\ForestResources\Http\Requests\ConcessionRequest;
use Modules\ForestResources\Services\Concession as ConcessionService;

class ConcessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, Concession::class , ['Email', 'Name', 'Company']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ConcessionRequest $request)
    {
       $data = $request->validated();

        Concession::create($data);

       return response()->json([
            'message' => lang('concession_create_succesful')
       ], 201);
    }

    /**
     * Show the specified resource.
     * @param Concession $concession
     * @return Response
     */
    public function show(Concession $concession)
    {
        return response()->json([
            'data' => $concession
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Concession $concession
     * @return Response
     */
    public function update(ConcessionRequest $request,Concession $concession)
    {
        $data = $request->validated();

        $concession->update($data);


        return response()->json([
            'message' => lang('concession_update_succesful')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Concession $concession)
    {
        $concession->delete();

        return response()->json([
            'message' => lang('concession_delete_succesful')
        ], 204);
    }

    /**
     * @param Request $request
     * @param ConcessionService $concessionService
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, ConcessionService $concessionService)
    {
        $request->validate(['bbox' => 'string']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'concessions',
                'features' => $concessionService->getVectors($request->get('bbox', config('forestresources.default_bbox')))
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listConcessions(Request $request)
    {
        $concessions = Concession::where('Name', 'like', "%{$request->get('name')}%")
            ->take($request->get('limit', 100))
            ->get(['Id', 'Name']);

        return response()->json([
            'data' => $concessions->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'Name' => $item->Name
                ];
            })
        ]);

    }

}
