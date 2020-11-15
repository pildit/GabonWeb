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
    public function index(Request $request, PageResults $pr)
    {
        /**
         * Todo show only PermitNOMobile == MobileId ( this is the parent permit list )
         * Todo also check if there are cases where we have permits where there are no parents for them.
         */
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, PermitEntity::class, ["PermitNo"],['annualallowablecut','clientcompany','concessionairecompany','transportercompany']));

    }

    /**
     * @param PermitEntity $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PermitEntity $permit)
    {

        /**
         * Todo - when PermitNOMobile == MobileId this is the parent permit. Add also permits related to PermitNoMobile ( as childs )
         */
        return response()->json([
            'data' => $permit->with(['items','concession','managementunit','developmentunit','annualallowablecut','clientcompany','concessionairecompany','transportercompany','user'])
        ]);
    }

    /**
     * @param Request $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, Permit $permitService)
    {
        $request->validate(['bbox' => 'string']);

        return response()->json([
            'data' => [
                'type' => 'FeatureCollection',
                'name' => 'permits',
                'features' => $permitService->getVectors($request->get('bbox', config('transport.default_bbox')))
            ]
        ]);
    }

    public function mobile(Permit $permitService)
    {
        $form = $permitService->getMobileForm();

        return response()->json([
            "data" => $form
        ]);
    }

    /**
     * @param CreatePermitRequest $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePermitRequest $request)
    {
        $data = $request->validated();

        $data['User'] = $this->jwtPayload('data.id');

        $srid = config('forestresources.srid');
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lon']}, {$data['Lat']}),4326),$srid)";
        $data['Geometry'] = isset($data['Geometry']) ? DB::raw("public.st_geomfromtext('".$data['Geometry']."', 5223)") : DB::raw("(select $geomQuery)");

        $permit = PermitEntity::create($data);

        return response()->json([
            'data' => $permit,
            'message' => lang("permit_created_successfully")
        ], 201);
    }

    /**
     * @param PermitEntity $permit
     * @param UpdatePermitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermitEntity $permit, UpdatePermitRequest $request)
    {
        $data = $request->validated();

        $data['User'] = $this->jwtPayload('data.id');

        $srid = config('forestresources.srid');
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lon']}, {$data['Lat']}),4326),$srid)";
        $data['Geometry'] = isset($data['Geometry']) ? DB::raw("public.st_geomfromtext('".$data['Geometry']."', 5223)") : DB::raw("(select $geomQuery)");

        $permit->update($data);

        return response()->json([
            'data' => $permit,
            'message' => lang('permit_update_successful')
        ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permit = PermitEntity::findOrFail($id);

        $permit->delete();

        return response()->json([
            'message' => lang('permit_delete_successful')
        ], 204);
    }

    /**
     * @param $permit
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTracking(Request $request)
    {

        $request->validate([
            'coords' => 'required',
            'coords.*.Lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'coords.*.Lon' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'coords.*.ObserveAt' => ['required', 'date'],
            'coords.*.MobileId' => 'required'
        ]);

        /** get the $coords from the request */
        $coords = $request->get('coords');

        /** save each set of $coordinates or update if same coords are sent */
        $trackings = [];
        foreach ($coords as $k => $coordinate) {
            $permit = PermitEntity::where('MobileId',$coordinate['MobileId'])->firstOrFail();

            $tracking = $permit->tracking()->where('Lat', $coordinate['Lat'])->where('Lon', $coordinate['Lon'])->first();

            $srid = config('transportation.srid');
            $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$coordinate['Lon']}, {$coordinate['Lat']}),4326),$srid)";

            $trackings[$k] = (!is_null($tracking)) ? $tracking : new Tracking();
            $trackings[$k]->User = $this->jwtPayload('data.id');
            $trackings[$k]->Lat = $coordinate['Lat'];
            $trackings[$k]->Lon = $coordinate['Lon'];
            $trackings[$k]->ObserveAt = $coordinate['ObserveAt'];
            $trackings[$k]->GpsAccu = $coordinate['GpsAccu'] ?? 0;
            $trackings[$k]->Geometry = DB::raw("(select $geomQuery)");
        }

        $permit->tracking()->saveMany($trackings);

        return response()->json([
            'message' => 'tracking_success'
        ],201);
    }
}
