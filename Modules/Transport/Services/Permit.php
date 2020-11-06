<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Company;
use Modules\Transport\Entities\Permit as PermitEntity;

class Permit extends PageResults
{

    /**
     * @param $bbox
     * @return mixed
     */
    public function getVectors($bbox)
    {
        $collection = PermitEntity::select(['Id', DB::raw('public.ST_AsGeoJSON(Geometry) as geom')])
            ->whereRaw("public.ST_Intersects(Geometry, public.ST_MakeEnvelope($bbox))")->get();

        return $collection->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => $item->geom,
                'properties' => [
                    'id' => $item->Id
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
                "f" => "PermitNo",
                "fl" => "PermitNo",
                "type" => "str_NotEmpty"
            ],
            [
                "f" => "PermitNoMobile",   //! asta e OK ... il lasi asa - NU adauga NotEmpty!!!
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "AnnualAllowableCut",   // AAC
                "fl" => "AnnualAllowableCut",
                "type" => "list_NotEmpty_NoLang",
                "values" => $aac         //! vezi aici ce faci
            ],
            [
                "f" => "ManagementUnit",     // UFG
                "fl" => "ManagementUnit",
                "type" => "list_NotEmpty_NoLang",
                "values" => $managementunit          //! vezi aici ce faci
            ],
            [
                "f" => "DevelopmentUnit",
                "fl" => "DevelopmentUnit",
                "type" => "str_NotEmpty",       //! aici lista
                "values" => $developmentunit
            ],
            [
                "f" => "Concession",
                "fl" => "Concession",
                "type" => "str_NotEmpty",         //! aici lista - FK consession
                "values" => $concession
            ],
            [
                "f" => "ConcessionaireCompany",
                "fl" => "ConcessionaireCompany",
                "type" => "str_NotEmpty",         //! aici lista - FK companies - type concesion?
                "values" => $concessionaire
            ],
            [
                "f" => "ClientCompany",
                "fl" => "ClientCompany",
                "type" => "str_NotEmpty",         //! aici lista - FK companies - type client
                "value" => $client
            ],
            [
                "f" => "TransporterCompany",
                "fl" => "TransporterCompany",
                "type" => "list_NotEmpty_NoLang",
                "values" => $transport     //! aici lista - FK companies - type transporter
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
            [
                "f" => "ProductType",
                "fl" => "ProductType",
                "type" => "list_NotEmpty",
                "values" => $product_types    //! vezi aici ce faci
            ],

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
}
