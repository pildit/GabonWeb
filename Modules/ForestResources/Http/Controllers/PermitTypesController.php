<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\PermitType;
use App\Services\PageResults;

class PermitTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(["Id"]);

        return response()->json($pr->getPaginator($request, PermitType::class , ['Abbreviation']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'abbreviation' => 'string|required',
            'name' => 'string'
        ]);


        PermitType::create([
            'Abbreviation' => $data['abbreviation'],
            'Name' => $data['name']
            ]);

        return \response()->json([
            'message' => lang('created_successfully')
        ], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, PermitType $permit_type)
    {
        $data = $request->validate([
            'abbreviation' => 'string|required',
            'name' => 'string'
        ]);

        $permit_type->fill([
            'Abbreviation' => $data['abbreviation'],
            'Name' => $data['name']
        ]);


        $permit_type->save();

        return response()->json([
            'message' => lang('update_successful')
        ], 200);
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