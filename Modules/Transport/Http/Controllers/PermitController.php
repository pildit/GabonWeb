<?php


namespace Modules\Transport\Http\Controllers;


use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Entities\Tracking;
use Modules\Transport\Http\Requests\CreatePermitRequest;
use Modules\Transport\Http\Requests\UpdatePermitRequest;
use Modules\Transport\Services\Permit;
use App\Services\PageResults;

class PermitController extends Controller
{
    use GetsJwtToken;

    /**
     * Returns list of permits paginated
     *
     * @param Request $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, PageResults $pageResults)
    {
        return response()
            ->json($pageResults->getPaginator($request, PermitEntity::class, ["harvest_name",
        "client_name", "concession_name"]));
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
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$request->get('lon')}, {$request->get('lat')}),4326),3857)";
        $permit = new PermitEntity();
        $permit->fill($request->all());
        $permit->the_geom = $permit->the_geom ?? DB::raw("(select $geomQuery)");
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
        $permit->update($request->validated());

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
    public function storeTracking($mobile_id, Request $request)
    {
        $request->validate([
            'coords' => 'required',
            'coords.*.lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'coords.*.lon' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'coords.*.obsdate' => ['required', 'date']
        ]);

        $permit = PermitEntity::where('mobile_id',$mobile_id)->firstOrFail();

        /** get the $coords from the request */
        $coords = $request->get('coords');

        /** save each set of $coordinates or update if same coords are sent */
        $trackings = [];
        foreach ($coords as $k => $coordinate) {
            $tracking = $permit->tracking()->where('Lat', $coordinate['lat'])->where('Lon', $coordinate['lon'])->first();

            $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$coordinate['lon']}, {$coordinate['lat']}),4326),3857)";
            $trackings[$k] = (!is_null($tracking)) ? $tracking : new Tracking();
            $trackings[$k]->User = $this->jwtPayload('data.id');
            $trackings[$k]->Lat = $coordinate['lat'];
            $trackings[$k]->Lon = $coordinate['lon'];
            $trackings[$k]->GPSAccuracy = $coordinate['gps_acu'] ?? 0;
            $trackings[$k]->ObserveAt = $coordinate['obsdate'];
            $trackings[$k]->Geometry = DB::raw("(select $geomQuery)");
        }

        $permit->tracking()->saveMany($trackings);

        return response()->json([
            'message' => 'success'
        ],201);
    }
}
