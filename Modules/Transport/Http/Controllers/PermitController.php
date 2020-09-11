<?php


namespace Modules\Transport\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Services\Permit;

class PermitController extends Controller
{
    /**
     * PermitController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt:api');
    }

    /**
     * Returns list of permits paginated
     *
     * @param Request $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Permit $permit)
    {
        $permit->validateRequest($request);
        $permit->setPage($request->get('page'));
        $permit->setPerPage($request->get('per_page'));

        return response()->json($permit->getPaginator());
    }

    /**
     * @param PermitEntity $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PermitEntity $permit)
    {
        return response()->json([
            'data' => $permit
        ]);
    }

    /**
     * @param Request $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, Permit $permit)
    {
        $request->validate(['bbox' => 'required']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'permits',
                'features' => $permit->getVectors($request->get('bbox'))
            ]
        ]);
    }
}
