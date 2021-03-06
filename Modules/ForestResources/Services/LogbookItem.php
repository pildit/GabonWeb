<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;

class LogbookItem extends PageResults
{

    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {


        list($species) = $this->speciesLists();
        list($annualallowablecutinventory) = $this->annualallowablecutinventoryList();

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
                "f" => "Logbook",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "TreeId",
                "fl" => "TreeId",   //!TreeId
                "type" => "list_ed_NotEmpty_NoLang",
                "values" => $annualallowablecutinventory
            ],
            [
                "f" => "HewingId",           //! AbatajID
                "fl" => "HewingId",
                "type" => "str_NotEmpty"
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
                "type" => "int_NotEmpty"
            ],
            [
                "f" => "MinDiameter",
                "fl" => "MinDiameter",
                "type" => "int_NotEmpty"
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

    /**
     * @return string[]
     */
    public function annualallowablecutinventoryList(): array
    {
        $array = [];

        $values = app('db')
            ->table('ForestResources.AnnualAllowableCutInventory')
            ->select('TreeId')
            ->get();

        $values->each(function ($value) use (&$array) {
            $array[]= [
                'val' => $value->TreeId
            ];

        });

        return array($array);
    }
}
