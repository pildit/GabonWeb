<?php


namespace Modules\Transport\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Http\Requests\CreatePermitRequest;
use Modules\Transport\Http\Requests\UpdatePermitRequest;
use Modules\Transport\Services\Permit;

class PermitController extends Controller
{

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
    public function vectors(Request $request, Permit $permitService)
    {
        $request->validate(['bbox' => 'required']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'permits',
                'features' => $permitService->getVectors($request->get('bbox'))
            ]
        ]);
    }

    public function mobile(Permit $permitService)
    {
        $form = $permitService->getMobileForm();

        return response()->json($form);
    }

    /**
     * @param CreatePermitRequest $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePermitRequest $request)
    {
        $permit = new PermitEntity();
        $permit->fill($request->all());
        $permit->save();

        return response()->json([
            'data' => $permit
        ], 201);
    }

    /**
     * @param PermitEntity $permit
     * @param UpdatePermitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermitEntity $permit, UpdatePermitRequest $request)
    {
        $permit->update($request->all());

        return response()->json([
            'data' => $permit
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permit = PermitEntity::findOrFail($id);

        $permit->delete();

        return response()->noContent();
    }
}
