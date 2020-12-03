<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Traits\Approve;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Services\PageResults;
use Modules\ForestResources\Entities\Species;
use GenTux\Jwt\GetsJwtToken;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;
use Modules\User\Entities\User;


class SpeciesController extends Controller
{
    use GetsJwtToken, Approve;

    private $modelName = Species::class;

    public function __construct()
    {
        $this->middleware('permission:species.view')->only('index', 'show');
        $this->middleware('permission:species.add|species.sync')->only('store');
        $this->middleware('permission:species.edit')->only('update');
        $this->middleware('permission:species.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

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
            'User' => $this->jwtPayload('data.id')
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
        $species = Species::where('LatinName', 'ilike', "%{$request->get('name')}%")
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ['Code', 'LatinName', 'CommonName'];
        $collection = Species::select('Id', 'Code', 'LatinName', 'CommonName');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();
        $collection = $collection->map(function ($item) {

            return [
                'Code'=>$item->Code,
                'LatinName'=>$item->LatinName,
                'CommonName'=>$item->CommonName,

            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'species.xlsx');
    }
}
