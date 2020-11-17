<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Services\PageResults;
use Modules\ForestResources\Entities\Species;
use GenTux\Jwt\GetsJwtToken;

class SpeciesController extends Controller
{
    use GetsJwtToken;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(["Id"]);

        return response()->json($pr->getPaginator($request, Species::class , ['Code', 'LatinName', 'CommonName']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'string|required',
            'latin-name' => 'string',
            'common-name' => 'string'
        ]);


        Species::create([
            'Code' => $data['code'],
            'LatinName' => $data['latin-name'] ??  null,
            'CommonName' => $data['common-name'] ??  null,
            'UserId' => $this->jwtPayload('data.id')
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
    public function update(Request $request, Species $species)
    {
        $data = $request->validate([
            'code' => 'string|required',
            'latin-name' => 'string',
            'common-name' => 'string'
        ]);

        $species->Code = $data['code'];

        if ($request->has('latin-name'))
            $species->LatinName = $data['latin-name'];

        if ($request->has('common-name'))
            $species->CommonName = $data['common-name'];

        $species->save();
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
