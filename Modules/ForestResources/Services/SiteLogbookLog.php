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
                "type" => "str"
            ],
            [
                "f" => "HewingId",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "Species",
                "fl" => "",
				"type" => "int"
             //   "type" => "list_NotEmpty_NoLang",
            //    "values" => $species
            ],
            [
                "f" => "LogId",
                "fl" => "LogId",
                "type" => "str"
            ],
            [
                "f" => "MinDiameter",
                "fl" => "MinDiameter",
                "type" => "int_NotEmpty"
            ],
            [
                "f" => "MaxDiameter",
                "fl" => "MaxDiameter",
                "type" => "int_NotEmpty"
            ],
            [
                "f" => "AverageDiameter",
                "fl" => "AverageDiameter",
                "type" => "float_NotEmpty"
            ],
            [
                "f" => "Length",
                "fl" => "Length",
                "type" => "float_NotEmpty"
            ],
            [
                "f" => "Volume",
                "fl" => "Volume",
                "type" => "float_NotEmpty"
            ],
            [
                "f" => "EvacuationDate",
                "fl" => "EvacuationDate",
                "type" => "date_NotEmpty"
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
