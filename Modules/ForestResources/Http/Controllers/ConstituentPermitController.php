<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ConstituentPermit;
use App\Services\PageResults;
use Modules\ForestResources\Http\Requests\CreateConstituentPermitRequest;
use GenTux\Jwt\GetsJwtToken;
use App\Traits\Approve;
use Modules\ForestResources\Services\ConstituentPermit as ConstituentPermitService;

class ConstituentPermitController extends Controller
{
    use GetsJwtToken, Approve;

    private $modelName = ConstituentPermit::class;

    public function __construct()
    {
        $this->middleware('permission:constituent-permit.view')->only('index', 'show');
        $this->middleware('permission:constituent-permit.add|constituent-permit.sync')->only('store');
        $this->middleware('permission:constituent-permit.edit')->only('update');
        $this->middleware('permission:constituent-permit.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, ConstituentPermit::class , ['PermitType', 'PermitNumber', 'Email'], ['permit_type']));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateConstituentPermitRequest $request)
    {
        $data = $request->validated();

        $constituent_permit = new ConstituentPermit;
        $constituent_permit->PermitType = $data['permit_type'];
        $constituent_permit->PermitNumber = $data['permit_number'];
        $constituent_permit->Geometry = $data['geometry'];
        $constituent_permit->User = $this->jwtPayload('data.id');

        $constituent_permit->save();

        return response()->json([
            'message' => lang("constituent_permit_created_successfully")
        ], 201);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(ConstituentPermit $constituent_permit)
    {
        return response()->json(['data' => $constituent_permit], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param ConstituentPermit $cp
     * @return Response
     */
    public function update(Request $request, ConstituentPermit $constituent_permit)
    {
        $data = $request->validate([
            'permit_type' => 'exists:pgsql.ForestResources.PermitTypes,Id',
            'permit_number' => 'string',
            'geometry' => 'string',
        ]);

        if ($request->has('permit_type'))
            $constituent_permit->PermitType = $data['permit_type'];

        if ($request->has('permit_number'))
            $constituent_permit->PermitNumber = $data['permit_number'];

        if ($request->has('geometry'))
            $constituent_permit->Geometry = $data['geometry'];

        $constituent_permit->save();

        return response()->json([
            'message' => lang('constituent_permit_updated_succcesfully')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(ConstituentPermit $constituent_permit)
    {
        $constituent_permit->delete();

        return response()->json([
            'message' => lang('constituent_permit_deleted')
        ], 204);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $collection = app('db')->table('ForestResources.ConstituentPermits')
            ->select('Id','Email', 'PermitTypeName', 'PermitNumber')
            ->whereNull('DeletedAt');

        if ($request->get('date_from')) {
            $collection = $collection->where("CreatedAt", ">=", $request->get('date_from'));
        }
        if ($request->get('date_to')) {
            $collection = $collection->where("CreatedAt", "<=", $request->get('date_to'));
        }
        $collection = $collection->get();

        return fastexcel($collection)->download('constituent_permits.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listConstituentPermits(Request $request)
    {
        $cp = ConstituentPermit::where('PermitNumber', 'ilike', "%{$request->get('name')}%")
            ->where('Approved', true)
            ->take($request->get('limit', 100))
            ->get(['Id', 'PermitNumber']);

        return response()->json([
            'data' => $cp->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'PermitNumber' => $item->PermitNumber
                ];
            })
        ]);
    }


    public function vectors(Request $request, ConstituentPermitService $constituentPermitService)
    {
        $request->validate(
            [
                'bbox' => 'string',
                'Id' => 'nullable|exists:Modules\ForestResources\Entities\ConstituentPermit,Id'
            ]);

        return response()->json([
            'type' => 'FeatureCollection',
            'name' => 'constituent_permit',
            'features' => $constituentPermitService->getVectors($request->get('bbox', config('forestresources.default_bbox')),$request->get('Id'))
        ]);
    }
}
