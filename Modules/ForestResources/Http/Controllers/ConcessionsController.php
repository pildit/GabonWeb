<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Traits\Approve;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Company;
use Modules\ForestResources\Entities\Concession;
use App\Services\PageResults;
use Modules\ForestResources\Entities\ConstituentPermit;
use Modules\ForestResources\Http\Requests\ConcessionRequest;
use Modules\ForestResources\Services\Concession as ConcessionService;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class ConcessionsController extends Controller
{
    use Approve, GetsJwtToken;

    private $modelName = Concession::class;

    public function __construct()
    {
        $this->middleware('permission:concession.view')->only('index', 'show');
        $this->middleware('permission:concession.add|concession.sync')->only('store');
        $this->middleware('permission:concession.edit')->only('update');
        $this->middleware('permission:concession.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

    }

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
       $data['User'] = $this->jwtPayload('data.id');

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
//        $concession->load(['constituent_permit', 'company']);

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
        $request->validate(
            [
                'bbox' => 'string',
                'Id' => 'nullable|exists:Modules\ForestResources\Entities\Concession,Id'
            ]);

        return response()->json([
            'type' => 'FeatureCollection',
            'name' => 'concessions',
            'features' => $concessionService->getVectors($request->get('bbox', config('forestresources.default_bbox')),$request->get('Id'))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listConcessions(Request $request)
    {
        $concessions = Concession::where('Name', 'ilike', "%{$request->get('name')}%")
            ->where('Approved', true)
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings = [ 'Name', 'Company', 'Continent', 'ConstituentPermit'];
        $collection = Concession::select('Id','Name', 'Company', 'Continent', 'ConstituentPermit');

        if ($request->get('date_from')) {
            $collection = $collection->where("CreatedAt", ">=", $request->get('date_from'));
        }
        if ($request->get('date_to')) {
            $collection = $collection->where("CreatedAt", "<=", $request->get('date_to'));
        }
        $collection = $collection->get();

        $collection = $collection->map(function ($item) {

            $Company = (Company::select("Name")->where("Id", $item->Company)->first()) ?
                Company::select("Name")->where("Id", $item->Company)->first()->Name :
                $item->Company;

            return [
                'Name' => $item->Name,
                'Company' => $Company,
                'Continent' => $item->Continent,
                'ConstituentPermit' => $item->ConstituentPermit
            ];
        });

        return Excel::download(new Exporter($collection, $headings), 'concession.xlsx');
    }

}
