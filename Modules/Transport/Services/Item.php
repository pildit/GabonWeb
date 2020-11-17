<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
use Modules\ForestResources\Entities\SiteLogbook;
use Modules\Transport\Entities\Item as ItemEntity;
use Modules\User\Entities\User;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Support\Facades\DB;

class Item extends PageResults
{
    use GetsJwtToken;
    public function getMobileForm()
    {
        /**
         * Todo change here to Species model
         */
        $species = app('db')
            ->table('Transportation.list_species')
            ->select('pop_name as val', 'id')
            ->get()->toArray();


        list($logID) = $this->logIdList();

        // mobile form
     	//!!! daca nu are "fl" NU pui NotEmpty!!!!
        $array = [
            [
                "f" => "MobileId",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "Permit",
                "fl" => "",
                "type" => "str"
            ],
            [
                "f" => "LogId",
                "fl" => "LogId",
                "type" => "list_ed_NotEmpty_NoLang",     //!!! LogId se transformă in LogID doar cu val... fără id din lista de LogId
                "values" => $logID
           //     "condition" => "product_type=logs"
            ],
            [
                'f' => 'Species',
                'fl' => 'Species',
                'type' => 'list_NotEmpty_NoLang',
                'values' => $species,
            ],
            [
                "f" => "MinDiameter",
                "fl" => "MinDiameter",
                "type" => "float_NotEmpty",
            //    "condition" => "product_type=logs"
            ],
            [
                "f" => "MaxDiameter",
                "fl" => "MaxDiameter",
                "type" => "float_NotEmpty",
           //     "condition" => "product_type=logs"
            ],
            [
                "f" => "AverageDiameter",
                "fl" => "AverageDiameter",
                "type" => "float_NotEmpty"
            ],
            [
                "f" => "Length",
                "fl" => "Length",
                "type" => "float_NotEmpty",
           //     "condition" => "product_type=logs,transformed"
            ],
            [
                "f" => "Volume",
                "fl" => "Volume",
                "type" => "float_NotEmpty",
          //      "condition" => "product_type=logs,transformed"
            ],
            [
                "f" => "Note",
                "fl" => "Note",
                "type" => "str"
            ]

        ];

        return $array;
    }

    public function logIdList(): array
    {
        $array = [];

        $userId = $this->jwtPayload('data.id');

        $concessions =  DB::table('admin.accounts')
            ->join('Taxonomy.Companies', 'admin.accounts.company_id', '=', 'Taxonomy.Companies.Id')
            ->join('ForestResources.Concessions', 'ForestResources.Concessions.Company', '=', 'Taxonomy.Companies.Id')
            ->select('ForestResources.Concessions.Id')
            ->where("admin.accounts.id","=", $userId)->get()->toArray();

        $concessions = array_column($concessions, 'Id');

        $SiteLogbooks = DB::table('ForestResources.SiteLogbooks')
            ->select('ForestResources.SiteLogbooks.Id')
            ->whereIn("ForestResources.SiteLogbooks.Concession",$concessions)->get();


        $SiteLogbooks->each(function ($SiteLogbook) use (&$array) {
            $SiteLogbook = SiteLogbook::find($SiteLogbook->Id);
            $SiteLogbook->logs()->get()->each(function ($value) use (&$array) {
                $array[]= [
                    'val' => $value->LogId,
                ];
            });
        });

        return array($array);
    }
}
