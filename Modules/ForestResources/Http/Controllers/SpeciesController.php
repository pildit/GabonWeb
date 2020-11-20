<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Traits\Approve;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Services\PageResults;
use Modules\ForestResources\Entities\Species;
use GenTux\Jwt\GetsJwtToken;

class SpeciesController extends Controller
{
    use GetsJwtToken, Approve;

    private $modelName = Species::class;

    public function __construct()
    {
        $this->middleware('can:species.view')->only('index', 'show');

        $this->middleware('can:species.add')->only('store');

        $this->middleware('can:species.edit')->only('update');

        $this->middleware('can:species.approve')->only('approve');

        $this->middleware('role:admin')->only('delete');

    }

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSpecies(Request $request)
    {
        $species = Species::where('LatinName', 'like', "%{$request->get('name')}%")
            ->take($request->get('limit', 100))
            ->get(['Id', 'LatinName', 'Code', 'CommonName']);

        return response()->json([
            'data' => $species->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'LatinName' => $item->LatinName,
                    'Code' => $item->Code,
                    'CommonName' => $item->CommonName
                ];
            })
        ]);

    }
}
