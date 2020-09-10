<?php


namespace Modules\Transport\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $permit->setOrderBy($request->get('orderBy', 'id'));
        $permit->setOrderDirection($request->get('orderDirection', 'desc'));

        return response()->json($permit->getPaginator());
    }
}
