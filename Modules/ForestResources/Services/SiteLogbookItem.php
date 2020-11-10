<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;

class SiteLogbookItem extends PageResults
{

    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {

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
                "f" => "SiteLogbook",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "HewingId",
                "fl" => "HewingId",
                "type" => "int"
            ],
            [
                "f" => "Date",
                "fl" => "Date",
                "type" => "date"
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



        ];


        return $formArr;
    }


}
