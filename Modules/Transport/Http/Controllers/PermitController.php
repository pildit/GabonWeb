<?php


namespace Modules\Transport\Http\Controllers;


use App\Traits\Approve;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Admin\Entities\Company;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Entities\Concession;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\ForestResources\Entities\ProductType;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Entities\Tracking;
use Modules\Transport\Http\Requests\CreatePermitRequest;
use Modules\Transport\Http\Requests\UpdatePermitRequest;
use Modules\Transport\Services\Permit;
use App\Services\PageResults;
use Modules\Transport\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;
use Modules\User\Entities\User;

class PermitController extends Controller
{
    use GetsJwtToken;
    use Approve;

    private $modelName = PermitEntity::class;

    public function __construct()
    {
        $this->middleware('permission:permit.view')->only('index', 'show', 'trackingVectors');
        $this->middleware('permission:permit.add|permit.sync')->only('store');
        $this->middleware('permission:permit.edit|scan_qr_code')->only('update');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Returns list of permits paginated
     *
     * @param Request $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Permit $pr)
    {

        $pr->setSortFields(['Id']);
        // CHECKME: not sure we need all these relationships.
//        $request->merge(['search'=>$request->get("search")]);
        // TODO: search does'nt work.
        return response()->json($pr->getPaginator($request, PermitEntity::class,
            ['PermitNo','AnnualAllowableCutName', 'TransporterCompanyName','LicensePlate'],
            ['annualallowablecut', 'clientcompany', 'concessionairecompany', 'transportercompany']
        ));

    }

    /**
     * @param PermitEntity $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PermitEntity $permit)
    {
        $permit['permit_child'] = PermitEntity::where('PermitNoMobile', $permit->PermitNoMobile)->where('Id', '!=', $permit->Id)->get();
        $permit->load(['annualallowablecut', 'clientcompany', 'concessionairecompany', 'transportercompany',
            'concession', 'managementunit', 'developmentunit']);
        return response()->json(['data' => $permit]);
    }

    /**
     * @param Request $request
     * @param Permit $permit
     * @return \Illuminate\Http\JsonResponse
     */
    public function vectors(Request $request, Permit $permitService)
    {
        $request->validate([
            'bbox' => 'string',
            'LicensePlate' => 'nullable|string',
            'DateFrom' => 'nullable|date_format:Y-m-d H:i:s',
            'DateTo' => 'nullable|date_format:Y-m-d H:i:s',
            'PermitNo'=>'nullable|string',
            'Date' => 'nullable|date_format:Y-m-d',
            'Id' => 'nullable|exists:Modules\ForestResources\Entities\Concession,Id'
        ]);


        return response()->json([
            'type' => 'FeatureCollection',
            'name' => 'permits',
            'features' => $permitService->getVectors(
                $request->get('bbox', config('transport.default_bbox')),
                $request->get('LicensePlate'),
                $request->get('DateFrom'),
                $request->get('DateTo'),
                $request->get('Date'),
                $request->get('PermitNo'),
                $request->get('Id')
            )
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
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lat']}, {$data['Lon']}),4326),$srid)";
        $data['Geometry'] = isset($data['Geometry']) ? DB::raw("public.st_geomfromtext('".$data['Geometry']."', $srid)") : DB::raw("(select $geomQuery)");

        $permitNumber = PermitEntity::where('PermitNo','ilike', $data['PermitNo']."%")->count();
        $permitNumber = sprintf("%04d", ++$permitNumber);
        $data['PermitNo'] = $data['PermitNo']."_".$permitNumber;

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
        $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$data['Lat']}, {$data['Lon']}),4326),$srid)";
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
            'coords.*.MobileId' => 'required',
            'coords.*.Status' => 'numeric',
        ]);

        /** get the $coords from the request */
        $coords = $request->get('coords');

        /** save each set of $coordinates or update if same coords are sent */
        $trackings = [];
        foreach ($coords as $k => $coordinate) {
            $permit = PermitEntity::where('MobileId',$coordinate['MobileId'])->firstOrFail();
            if(!$permit){
                throw ValidationException::withMessages(['Permit' => 'validation.exists']);
            }
            $permits = PermitEntity::where('PermitNoMobile', $permit->PermitNoMobile)->get();
            $status = $coordinate['Status'] ?? PermitEntity::STATUS_IN_PROGRESS;
            foreach($permits as $pr){
                if($pr->Status != PermitEntity::STATUS_IN_PROGRESS && $status == PermitEntity::STATUS_IN_PROGRESS){
                    $pr->update([
                        'Status' => $status
                    ]);
                }
                if($pr->Status != PermitEntity::STATUS_FINISHED && $status == PermitEntity::STATUS_FINISHED){
                    $pr->update([
                        'Status' => $status
                    ]);
                }
            }

            $tracking = $permit->tracking()->where('Lat', $coordinate['Lat'])->where('Lon', $coordinate['Lon'])->first();

            $srid = config('forestresources.srid');
            $geomQuery = "public.st_transform(public.st_setsrid(public.st_point({$coordinate['Lat']}, {$coordinate['Lon']}),4326),$srid)";

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

    /**
     * @param Request $request
     * @param Permit $permitService
     * @return \Illuminate\Http\JsonResponse
     */

    public function trackingVectors(Request $request, Permit $permitService){
        $request->validate([
            'bbox' => 'string',
        ]);

        return response()->json([
            'type' => 'FeatureCollection',
            'name' => 'tracking',
            'features' => $permitService->getTrackingVectors(
                $request->get('bbox', config('transport.default_bbox'))
            )
        ]);
    }

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = [ "PermitNo", "Concession", "ManagementUnit", "DevelopmentUnit", "AnnualAllowableCut", "ClientCompany", "ConcessionaireCompany", "TransporterCompany", "User", "ProductType", "Status", "DriverName", "LicensePlate", "Province", "Destination", "ScanLat", "ScanLon", "ScanGpsAccu", "Lat", "Lon", "GpsAccu", "ObserveAt"];
        $collection = PermitEntity::select("Id", "PermitNo", "Concession", "ManagementUnit", "DevelopmentUnit", "AnnualAllowableCut", "ClientCompany", "ConcessionaireCompany", "TransporterCompany", "User", "ProductType", "Status", "DriverName", "LicensePlate", "Province", "Destination", "ScanLat", "ScanLon", "ScanGpsAccu", "Lat", "Lon", "GpsAccu", "ObserveAt");
        $permits_table = (new PermitEntity())->getTable();
        $collection = app('db')->table($permits_table)
            ->select("Id", "PermitNo", "Concession", "ManagementUnit", "DevelopmentUnit", "AnnualAllowableCut as AnnualAllowableCut", "ClientCompanyName as ClientCompany",
                "ConcessionaireCompanyName as ConcessionaireCompany", "TransporterCompanyName as TransporterCompany", "Email", "ProductType", "Status", "DriverName", "LicensePlate",
                "Province", "Destination", "ScanLat", "ScanLon", "ScanGpsAccu", "Lat", "Lon", "GpsAccu", "ObserveAt");

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();

        return fastexcel($collection)->download('transport_permits.xlsx');
    }
}
