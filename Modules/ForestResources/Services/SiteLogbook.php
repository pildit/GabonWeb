<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;

class SiteLogbook extends PageResults
{

    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {

        list($developmentunit) = $this->developmentunitList();
        list($managementunit) = $this->managementunitList();
        list($annualallowablecut) = $this->annualallowablecutList();
        list($concession) = $this->concessionList();
        list($companies) = $this->companiesList();

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
                "f" => "Concession",
                "fl" => "Concession",
                "type" => "list_NotEmpty_NoLang",
                "values" => $concession
            ],
            [
                "f" => "DevelopmentUnit",
                "fl" => "DevelopmentUnit",
                "type" => "list_NotEmpty_NoLang",
                "values" => $developmentunit
            ],
            [
                "f" => "ManagementUnit",
                "fl" => "ManagementUnit",
                "type" => "list_NotEmpty_NoLang",
                "values" => $managementunit
            ],
            [
                "f" => "Company",
                "fl" => "Company",
                "type" => "list_NotEmpty_NoLang",
                "values" => $developmentunit
            ],
            [
                "f" => "Hammer",
                "fl" => "Hammer",
                "type" => "int"
            ],
            [
                "f" => "Localization",
                "fl" => "Localization",
                "type" => "str"
            ],
            [
                "f" => "ReportNo",
                "fl" => "ReportNo",
                "type" => "str"
            ],
            [
                "f" => "ReportNote",
                "fl" => "ReportNote",
                "type" => "str"
            ],


        ];


        return $formArr;
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

    /**
     * @return string[]
     */
    public function companiesList(): array
    {
        $array = [];

        $values = app('db')
            ->table('Taxonomy.Companies')
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
