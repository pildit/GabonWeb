<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Company;
use Modules\Transport\Entities\Permit as PermitEntity;
use Modules\Transport\Entities\Tracking;


class Permit extends PageResults
{

    /**
     * @param $bbox
     * @param $LicensePlate
     * @param $DateFrom
     * @param $DateTo
     * @param $Date
     * @param $PermitNo
     * @param $Id
     * @return mixed
     */
    public function getVectors($bbox,$LicensePlate,$DateFrom,$DateTo,$Date,$PermitNo,$Id)
    {
        $srid = config('forestresources.srid');
        $geomCol = DB::raw('public.ST_AsGeoJSON(public.st_transform(public.st_setsrid("Geometry",'.$srid.'),4326)) as geom');
//        $whereIntersects = "public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))";

        $collection = PermitEntity::select(['Id', $geomCol, "PermitNo", "Concession", "ManagementUnit", "DevelopmentUnit", "AnnualAllowableCut", "ClientCompany", "ConcessionaireCompany", "TransporterCompany", "Province", "Destination","LicensePlate","ObserveAt"]);

        if($Id){
            $collection = $collection->where("Id","=",$Id);
        }
        if($LicensePlate){
            $collection = $collection->where('LicensePlate','ilike',"%".$LicensePlate."%");
        }
        if($DateFrom){
            $collection = $collection->where('ObserveAt','>=',$DateFrom);
        }
        if($DateTo){
            $collection = $collection->where('ObserveAt','<=',$DateTo);
        }
        if($Date){
            $collection = $collection->where('ObserveAt','>',$Date.' 00:00:00')->where('ObserveAt','<=',$Date.' 23:59:59');
        }
        if($PermitNo){
            $collection = $collection->where('PermitNo','ilike',"%".$PermitNo."%");
        }

        $collection = $collection->get();

        return $collection->map(function ($item) {

            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    "id" => $item->Id,
                    "PermitNo" => $item->PermitNo,
                    "Concession" => $item->concession ? $item->concession->Name : $item->Concession,
                    "ManagementUnit" => $item->managementunit ? $item->managementunit->Name : $item->ManagementUnit,
                    "DevelopmentUnit" => $item->developmentunit ? $item->developmentunit->Name : $item->DevelopmentUnit,
                    "AnnualAllowableCut" => $item->annualallowablecut ? $item->annualallowablecut->Name : $item->AnnualAllowableCut,
                    "ClientCompany" => $item->clientcompany ? $item->clientcompany->Name : $item->ClientCompany,
                    "ConcessionaireCompany" =>  $item->concessionairecompany ? $item->concessionairecompany->Name : $item->ConcessionaireCompany,
                    "TransporterCompany" =>  $item->transportercompany ? $item->transportercompany->Name : $item->TransporterCompany,
                    "Province" => $item->Province,
                    "Destination" => $item->Destination,
                    "LicensePlate" => $item->LicensePlate,
                    "ObserveAt" => $item->ObserveAt,
                ]
            ];
        });
    }

    /**
     * @param $bbox
     * @return mixed
     */
    public function getTrackingVectors($bbox)
    {
        $srid = config('forestresources.srid');
        $geomCol = DB::raw('public.ST_AsGeoJSON(public.st_transform(public.st_setsrid("Geometry",'.$srid.'),4326)) as geom');
//        $whereIntersects = "public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))";

        $collection = Tracking::select(['Id', $geomCol, "Permit"])
            ->whereHas('permit', function ($query) {
                $query->where('Status', '=', PermitEntity::STATUS_IN_PROGRESS);
            });

        $collection = $collection->get();

        return $collection->map(function ($item) {

            return [
                'type' => 'Feature',
                'geometry' => $item->geom,
                'properties' => [
                    "id" => $item->Id,
                    "LicensePlate" => $item->permit ? $item->permit->LicensePlate : '',
                    "DriverName" => $item->permit ? $item->permit->DriverName : '',
                    "PermitNo" => $item->permit ? $item->permit->PermitNo : '',
                    "Destination" => $item->permit ? $item->permit->Destination : '',
                    "Province" => $item->permit ? $item->permit->Province : '',
                ]
            ];
        });
    }


    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {
        list($product_types) = $this->productTypesList();

        list($aac) = $this->annualAllowableCutLists();
        list($concession) = $this->concessionList();
        list($developmentunit) = $this->developmentunitList();
        list($managementunit) = $this->managementunitList();

        list($client, $transport, $concessionaire) = $this->companiesList();

        // mobile form
		//!!! daca nu are "fl" NU pui NotEmpty!!!!
        $formArr = [
            [
                "f" => "ObserveAt",
                "fl" => "",
                "type" => "date"
            ],
            [
                "f" => "MobileId",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "GpsAccu",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "Lat",
                "fl" => "Lat",
                "type" => "float_NotEmpty",
                "group" => "Location"
            ],
            [
                "f" => "Lon",
                "fl" => "Lon",
                "type" => "float",
                "group" => "Location"
            ],

            [
                "f" => "ScanLat",
                "fl" => "",
                "type" => "float"
            ],
            [
                "f" => "ScanLon",
                "fl" => "",
                "type" => "float"
            ],
            [
                "f" => "ScanGpsAccu",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "Status",     //! 1- generat / 2 - in progress / 3 - finished
                "fl" => "",          // nu trebuie sa faci nimic ... valorile vin hardcoded  1,2,3
                "type" => "int"
            ],

            [
                "f" => "PermitNo",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "PermitNoMobile",   //! asta e OK ... il lasi asa - NU adauga NotEmpty!!!
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "AnnualAllowableCut",
                "fl" => "AnnualAllowableCut",
                "type" => "list_NotEmpty_NoLang",
                "values" => $aac
            ],
            [
                "f" => "ManagementUnit",
                "fl" => "ManagementUnit",
                "type" => "list_NotEmpty_NoLang",
                "values" => $managementunit
            ],
            [
                "f" => "DevelopmentUnit",
                "fl" => "DevelopmentUnit",
                "type" => "list_NotEmpty_NoLang",
                "values" => $developmentunit
            ],
            [
                "f" => "Concession",
                "fl" => "Concession",
                "type" => "list_NotEmpty_NoLang",
                "values" => $concession
            ],
            [
                "f" => "ConcessionaireCompany",
                "fl" => "ConcessionaireCompany",
                "type" => "list_NotEmpty_NoLang",
                "values" => $concessionaire
            ],
            [
                "f" => "ClientCompany",
                "fl" => "ClientCompany",
                "type" => "list_NotEmpty_NoLang",
                "values" => $client
            ],
            [
                "f" => "TransporterCompany",
                "fl" => "TransporterCompany",
                "type" => "list_NotEmpty_NoLang",
                "values" => $transport
            ],
            [
                "f" => "DriverName",
                "fl" => "DriverName",
                "type" => "str_NotEmpty"
            ],
            [
                "f" => "LicensePlate",
                "fl" => "LicensePlate",
                "type" => "str_NotEmpty"
            ],
            [
                "f" => "Province",
                "fl" => "Province",
                "type" => "str_NotEmpty"
            ],
            [
                "f" => "Destination",
                "fl" => "Destination",
                "type" => "str_NotEmpty",
        //        "values" => $destinations
            ],

	   //! pentru moment e default resource = logs - facut default in DB
    /*        [
                "f" => "ProductType",
                "fl" => "ProductType",
                "type" => "list_NotEmpty",
                "values" => $product_types    //! vezi aici ce faci
            ],
     */
	/*		!! not needed yet dar in viitoru apropiat ighen - ighen draga
	        [
				"f":"Photos",
				"fl":"Photos",
				"type":"photo"
			],
	*/
        ];


        return $formArr;
    }

    /**
     * @return string[]
     */
    public function productTypesList(): array
    {

        $product_types = PermitEntity::$PRODUCT_TYPES;

        foreach($product_types as $k => $product_type){
            $product_types = [
                'id' => $product_type,
                'val' => $k
            ];
        }

        return array($product_types);
    }

    /**
     * @return string[]
     */
    public function companiesList(): array
    {
        $client = [];
        $transport= [];
        $concessionaire = [];

        $companies = Company::all();

        $companies->each(function ($company) use (&$client, &$transport, &$concessionaire) {
            foreach ($company->types()->get()->toArray() as $type){
                if ("client" ==$type['Name']) {
                    $client[] = [
                        'id' => $company->Id,
                        'val' => $company->Name
                    ];
                }
                if ("transporter" ==$type['Name']) {
                    $transport[]= [
                        'id' => $company->Id,
                        'val' => $company->Name
                    ];
                }
                if ("concessionaire" ==$type['Name']) {
                    $concessionaire[]= [
                        'id' => $company->Id,
                        'val' => $company->Name
                    ];
                }
            }

        });
        return array($client, $transport, $concessionaire);
    }

    public function annualAllowableCutLists(): array
    {
        $array = [];

        $values = app('db')
            ->table('ForestResources.AnnualAllowableCuts')
            ->select( 'Id','Name')
            ->get();

        $values->each(function ($value) use (&$array) {
            $array[]= [
                'val' => $value->Name,
                'id'  => $value->Id,
            ];

        });

        return array($array);
    }

    /**
     * @return string[]
     */
    public function concessionList(): array
    {
        $array = [];

        $values = app('db')
            ->table('ForestResources.Concessions')
            ->select( 'Id','Name')
            ->get();

        $values->each(function ($value) use (&$array) {
            $array[]= [
                'val' => $value->Name,
                'id'  => $value->Id,
            ];

        });

        return array($array);
    }

    /**
     * @return string[]
     */
    public function developmentunitList(): array
    {
        $array = [];

        $values = app('db')
            ->table('ForestResources.DevelopmentUnits')
            ->select( 'Id','Name')
            ->get();

        $values->each(function ($value) use (&$array) {
            $array[]= [
                'val' => $value->Name,
                'id'  => $value->Id,
            ];

        });

        return array($array);
    }


    /**
     * @return string[]
     */
    public function managementunitList(): array
    {
        $array = [];

        $values = app('db')
            ->table('ForestResources.ManagementUnits')
            ->select( 'Id','Name')
            ->get();

        $values->each(function ($value) use (&$array) {
            $array[]= [
                'val' => $value->Name,
                'id'  => $value->Id,
            ];

        });

        return array($array);
    }

    public function getPaginator(Request $request,string $model,array $searchFields, array $relations = [], $hidden = [])
    {

        $this->validateRequest($request);
        $this->setPage($request->get('page'));
        $this->setPerPage($request->get('per_page'));
        $this->setSearch($request->get('search'));

        $this->query = $model::ofSort($this->getSortCriteria());

        if(count($relations)){
            $this->query =  $this->query->with($relations);
        }

        /**
         * TODO check if there are cases where we have permits without parent ( PermitNoMobile = MobileId )
         */
//        $this->query->whereColumn('PermitNoMobile','MobileId');

        return $this->setFilters($searchFields)->getResults();
    }
}
