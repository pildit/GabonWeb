<?php


namespace Modules\Transport\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Entities\Tracking;
use Modules\Transport\Http\Requests\CreatePermitRequest;
use Modules\Transport\Http\Requests\UpdatePermitRequest;
use Modules\Transport\Services\Permit;
use MStaack\LaravelPostgis\Geometries\LineString;
use MStaack\LaravelPostgis\Geometries\Point;
use MStaack\LaravelPostgis\Geometries\Polygon;

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

    /**
     * @param $permit
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTracking($permit, Request $request)
    {
        $request->validate([
            'coords' => 'required',
            'coords.*.lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'coords.*.lon' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);

        /** find $tracking for the permit or initialize a new one */
        $rawQueryToCastGeometry = 'public.st_asgeojson(public.st_transform(public.st_setsrid("Geometry", 3857), 4326)) as Geom';
        $tracking = Tracking::select(['Id', DB::raw('' . $rawQueryToCastGeometry)])
            ->firstOrNew(['Permit' => $permit]);

        /** get the $coords from the reques */
        $coords = $request->get('coords');

        /** $pointsQuery should cointain string of  postgis point function comma separated */
        $pointsQuery = '';

        /**
         * if there is a current Geometry (we found a tracking record for the permit)
         * build up the query and filter the request array for duplicates
         */
        if($tracking->geom) {
            foreach (collect($tracking->geom->coordinates)->unique() as $coordinate) {
                $pointsQuery .= "public.st_point({$coordinate[0]}, {$coordinate[1]}),";
                $coords = array_values(collect($coords)->filter(function ($item) use ($coordinate) {
                    return $item['lat'] != $coordinate[0] || $item['lon'] != $coordinate[1];
                })->unique()->toArray());
            }
        }

        /**
         * finally with what remains in the $coordinate after the filtering above
         * build the rest of the query for the geom
         */
        foreach ($coords as $coordinate) {
            $pointsQuery .= "public.st_point({$coordinate['lat']}, {$coordinate['lon']}),";
        }
        //remove the trail comma
        $pointsQuery = substr($pointsQuery, 0, -1);

        /** $geomQuery - build the line from the array of points  */
        $geomQuery = "public.st_transform(public.st_setsrid(public.ST_MakeLine(ARRAY[ {$pointsQuery} ]  ),4326),3857)";

        $tracking->User = 1;
        $tracking->Geometry = DB::raw("(select $geomQuery)");
        $tracking->Permit = $permit;

        $tracking->save();

        return response()->json([
            'data' => $tracking->select(['*', DB::raw($rawQueryToCastGeometry)])->firstOrNew(['Permit' => $permit])
        ],201);
    }
}
