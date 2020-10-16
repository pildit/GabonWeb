<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\Concession;
use App\Services\PageResults;
use Modules\ForestResources\Http\Requests\ConcessionRequest;

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
            'message' => lang('Create succesful')
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

        $concession->fill($data);

        $concession->save();

        return response()->json([
            'message' => lang('Update succesful')
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
            'message' => lang('Delete succesful')
        ], 204);        
    }
}