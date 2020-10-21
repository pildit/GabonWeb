<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
use Modules\Transport\Entities\Item as ItemEntity;

class Item extends PageResults
{

    public function getMobileForm()
    {
        $species = app('db')
            ->table('transportation.list_species')
            ->select('pop_name as val', 'id')
            ->get()->toArray();

        // mobile form
        $array = [
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
                "f" => "permit_id",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "trunk_number",
                "fl" => "trunk_number",
                "type" => "str_NotEmpty",
                "condition" => "product_type=logs"
            ],
            [
                "f" => "lot_number",
                "fl" => "lot_number",
                "type" => "str_NotEmpty",
                "condition" => "product_type=transformed"
            ],
            [
                'f' => 'species',
                'fl' => 'species',
                'type' => 'list_NotEmpty_NoLang',
                'values' => $species,
            ],
            [
                "f" => "diam1",
                "fl" => "diam1",
                "type" => "float_NotEmpty",
                "condition" => "product_type=logs"
            ],
            [
                "f" => "diam2",
                "fl" => "diam2",
                "type" => "float_NotEmpty",
                "condition" => "product_type=logs"
            ],
            [
                "f" => "diam_avg",
                "fl" => "",
                "type" => "int"
            ],
            [
                "f" => "length",
                "fl" => "length",
                "type" => "float_NotEmpty",
                "condition" => "product_type=logs,transformed"
            ],
            [
                "f" => "width",
                "fl" => "width",
                "type" => "int_NotEmpty",
                "condition" => "product_type=transformed"
            ],
            [
                "f" => "height",
                "fl" => "height",
                "type" => "int_NotEmpty",
                "condition" => "product_type=transformed"
            ],
            [
                "f" => "volume",
                "fl" => "volume",
                "type" => "float_NotEmpty",
                "condition" => "product_type=logs,transformed"
            ],
            [
                "f" => "note",
                "fl" => "note",
                "type" => "str"
            ]

        ];

        return $array;
    }
}
