<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;

class SiteLogbookLog extends PageResults
{

    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {
        list($species) = $this->speciesLists();
        // mobile form
        $formArr = [

            [
                "f" => "ObserveAt",
                "fl" => "",
                "type" => "str"
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
                "f" => "SiteLogbookItem",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "HewingId",
                "fl" => "HewingId",
                "type" => "int"
            ],
            [
                "f" => "Species",
                "fl" => "Species",
                "type" => "list_NotEmpty_NoLang",
                "values" => $species
            ],

            [
                "f" => "MaxDiameter",
                "fl" => "MaxDiameter",
                "type" => "int"
            ],
            [
                "f" => "MinDiameter",
                "fl" => "MinDiameter",
                "type" => "int"
            ],
            [
                "f" => "AverageDiameter",
                "fl" => "AverageDiameter",
                "type" => "int"
            ],
            [
                "f" => "Length",
                "fl" => "Length",
                "type" => "int"
            ],
            [
                "f" => "Volume",
                "fl" => "Volume",
                "type" => "int"
            ],
            [
                "f" => "EvacuationDate",
                "fl" => "EvacuationDate",
                "type" => "date"
            ],
            [
                "f" => "Note",
                "fl" => "Note",
                "type" => "str"
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
}
