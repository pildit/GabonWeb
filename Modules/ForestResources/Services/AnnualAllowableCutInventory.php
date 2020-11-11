<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Str;

class AnnualAllowableCutInventory extends PageResults
{

    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {
        list($species) = $this->speciesLists();
        list($parcel) = $this->parcelList();
        list($quality) = $this->qualityList();
        list($annualallowablecut) = $this->annualallowablecutList();

        // mobile form
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
                "f" => "AnnualAllowableCut",
                "fl" => "AnnualAllowableCut",
                "type" => "list_NotEmpty_NoLang",
                "values" => $annualallowablecut
            ],
            [
                "f" => "Species",
                "fl" => "Species",
                "type" => "list_NotEmpty_NoLang",
                "values" => $species
            ],
            [
                "f" => "Quality",
                "fl" => "Quality",
                "type" => "list_NotEmpty",
                "values" => $quality
            ],
            [
                "f" => "Parcel",
                "fl" => "Parcel",
                "type" => "list_NotEmpty_NoLang",
                "values" => $parcel
            ],
            [
                "f" => "TreeId",
                "fl" => "TreeId",
                "type" => "str"
            ],
            [
                "f" => "DiameterBreastHeight",
                "fl" => "DiameterBreastHeight",
                "type" => "int"
            ],

        ];


        return $formArr;
    }


    /**
     * @return string[]
     */
    public function speciesLists(): array
    {
        $species_array = [];

        $species = app('db')
            ->table('Taxonomy.Species')
            ->select( 'Id','CommonName')
            ->get();

        $species->each(function ($specie) use (&$species_array) {
            $species_array[] = [
                'val' => $specie->CommonName,
                'id'  => $specie->Id,
            ];
        });

        return array($species_array);
    }


    /**
     * @return string[]
     */
    public function parcelList(): array
    {
        $parcel_array = [];

        $parcels = app('db')
            ->table('ForestResources.Parcels')
            ->select( 'Id','Name')
            ->get();

        $parcels->each(function ($parcel) use (&$parcel_array) {
            $parcel_array[] = [
                'val' => $parcel->Name,
                'id'  => $parcel->Id,
            ];
        });

        return array($parcel_array);

    }


    /**
     * @return string[]
     */
    public function qualityList(): array
    {
        $qualities_array = [];

        $qualities = app('db')
            ->table('ForestResources.InventoryQualities')
            ->select( 'Id','Value')
            ->get();

        $qualities->each(function ($quality) use (&$qualities_array) {
            $qualities_array[]= [
                'val' => $quality->Value,
                'id'  => $quality->Id,
            ];

        });

        return array($qualities_array);
    }

    /**
     * @return string[]
     */
    public function annualallowablecutList(): array
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
}
