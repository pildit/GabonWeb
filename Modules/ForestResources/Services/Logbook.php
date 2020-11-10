<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;

class Logbook extends PageResults
{

    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {

        list($concession) = $this->concessionList();
        list($developmentunit) = $this->developmentunitList();
        list($managementunit) = $this->managementunitList();
        list($annualallowablecut) = $this->annualallowablecutList();

        // mobile form
        $formArr = [
            [
                "f" => "ObserveAt",
                "fl" => "",
                "type" => "date"
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
                "f" => "AnnualAllowableCut",
                "fl" => "AnnualAllowableCut",
                "type" => "list_NotEmpty_NoLang",
                "values" => $annualallowablecut
            ],
            [
                "f" => "MobileId",
                "fl" => "",
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

}
