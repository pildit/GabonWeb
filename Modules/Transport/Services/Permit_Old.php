<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Transport\Entities\Permit as PermitEntity;

class Permit extends PageResults
{

    /**
     * @param $bbox
     * @return mixed
     */
    public function getVectors($bbox)
    {
        $collection = PermitEntity::select(['id', DB::raw('public.ST_AsGeoJSON(the_geom) as geom')])
            ->whereRaw("public.ST_Intersects(the_geom, public.ST_MakeEnvelope($bbox))")->get();

        return $collection->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => $item->geom,
                'properties' => [
                    'id' => $item->id
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
        list($product_types, $destinations) = $this->productAndDestinationLists();

        list($client_name, $transport_comp, $harvest_name) = $this->companiesList();

        // mobile form
        $formArr = [
            [
                "f" => "obsdate",
                "fl" => "",
                "type" => "date"
            ],
            [
                "f" => "appuser",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "mobile_id",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "gps_accu",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "permit_status",
                "fl" => "",
                "default" => "ready",
                "type" => "str"
            ],
            [
                "f" => "generated_by",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "verified_by",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "transport_by",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "scan_lat",
                "fl" => "",
                "type" => "float"
            ],
            [
                "f" => "scan_lon",
                "fl" => "",
                "type" => "float"
            ],
            [
                "f" => "scan_gps_accu",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "lat",
                "fl" => "Lat",
                "type" => "float_NotEmpty",
                "group" => "Location"
            ],
            [
                "f" => "lon",
                "fl" => "Long",
                "type" => "float",
                "group" => "Location"
            ],
            [
                "f" => "permit_no",
                "fl" => "permit_no",
                "type" => "str_NotEmpty"
            ],
            [
                "f" => "harvest_name",
                "fl" => "harvest_name",
                "type" => "list_NotEmpty_NoLang",
                "values" => $harvest_name
            ],
            [
                "f" => "client_name",
                "fl" => "client_name",
                "type" => "list_NotEmpty_NoLang",
                "values" => $client_name
            ],
            [
                "f" => "concession_name",
                "fl" => "concession_name",
                "type" => "str"
            ],
            [
                "f" => "transport_comp",
                "fl" => "transport_comp",
                "type" => "list_NotEmpty_NoLang",
                "values" => $transport_comp
            ],
            [
                "f" => "license_plate",
                "fl" => "license_plate",
                "type" => "str_NotEmpty"
            ],
            [
                "f" => "destination",
                "fl" => "destination",
                "type" => "list_NotEmpty",
                "values" => $destinations
            ],
            [
                "f" => "management_unit",
                "fl" => "management_unit",
                "type" => "str"
            ],
            [
                "f" => "operational_unit",
                "fl" => "operational_unit",
                "type" => "str"
            ],
            [
                "f" => "annual_operational_unit",
                "fl" => "annual_operational_unit",
                "type" => "str"
            ],
            [
                "f" => "product_type",
                "fl" => "product_type",
                "type" => "list_NotEmpty",
                "values" => $product_types
            ],
            [
                "f" => "note",
                "fl" => "note",
                "type" => "str"
            ]
        ];


        return $formArr;
    }

    /**
     * @return string[]
     */
    public function productAndDestinationLists(): array
    {
        $product_types = [];
        $destinations = [];

        $permitList = app('db')
            ->table('transportation.permits_lists')
            ->select('field', 'val')
            ->get();


        $permitList->each(function ($item) use (&$product_types, &$destinations) {
            if ($item->field == 'product_type') {
                $product_types[]['val'] = $item->val;
            }

            if ($item->field == 'destination') {
                $destinations[]['val'] = $item->val;
            }
        });
        return array($product_types, $destinations);
    }

    /**
     * @return string[]
     */
    public function companiesList(): array
    {
        $client_name = [];
        $transport_comp = [];
        $harvest_name = [];

        $companies = app('db')
            ->table('transportation.companies')
            ->select('field', 'comp_name')
            ->get();

        $companies->each(function ($company) use (&$client_name, &$transport_comp, &$harvest_name) {
            if (Str::contains($company->field, 'client_name')) {
                $client_name[]['val'] = $company->comp_name;
            }

            if (Str::contains($company->field, 'transport_comp')) {
                $transport_comp[]['val'] = $company->comp_name;
            }

            if (Str::contains($company->field, 'harvest_name')) {
                $harvest_name[]['val'] = $company->comp_name;
            }
        });
        return array($client_name, $transport_comp, $harvest_name);
    }
}
