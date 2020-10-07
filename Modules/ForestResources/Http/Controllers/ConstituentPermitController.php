<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ConstituentPermit;
use App\Services\PageResults;
use Modules\ForestResources\Http\Requests\CreateConstituentPermitRequest;

class ConstituentPermitController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        return response()->json($pr->getPaginator($request, ConstituentPermit::class , ['email']));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateConstituentPermitRequest $request)
    {
        $data = $request->validated();

        ConstituentPermit::create($data);

        return response()->json([
            'message' => lang("created_successfully")
        ], 201);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(ConstituentPermit $cp)
    {
        return response()->json(['data' => $cp], 200);    
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param ConstituentPermit $cp
     * @return Response
     */
    public function update(Request $request, ConstituentPermit $cp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
