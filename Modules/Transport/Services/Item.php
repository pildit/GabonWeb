<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
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


        list($treeID) = $this->treeIdList();

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
                "values" => $treeID
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

    public function treeIdList(): array
    {
        $array = [];

        $userId = $this->jwtPayload('data.id');

        // User > Company > Concessions -> Developtment Unit -> Management Unit -> AAC -> AAC Inventory > TreeIDs

        $values = DB::table('admin.accounts')
            ->join('Taxonomy.Companies', 'admin.accounts.company_id', '=', 'Taxonomy.Companies.Id')
            ->join('ForestResources.Concessions', 'ForestResources.Concessions.Company', '=', 'Taxonomy.Companies.Id')
            ->join('ForestResources.DevelopmentUnits', 'ForestResources.Concessions.Id',"=", 'ForestResources.DevelopmentUnits.Concession')
            ->join('ForestResources.ManagementUnits', 'ForestResources.ManagementUnits.DevelopmentUnit',"=", 'ForestResources.DevelopmentUnits.Id')
            ->join('ForestResources.AnnualAllowableCuts', 'ForestResources.AnnualAllowableCuts.ManagementUnit',"=", 'ForestResources.ManagementUnits.Id')
            ->join('ForestResources.AnnualAllowableCutInventory', 'ForestResources.AnnualAllowableCutInventory.AnnualAllowableCut',"=", 'ForestResources.AnnualAllowableCuts.Id')
            ->select('ForestResources.AnnualAllowableCutInventory.Id','ForestResources.AnnualAllowableCutInventory.LogId')
            ->where("admin.accounts.id","=", $userId)
            ->get();

//                $values = DB::table('ForestResources.AnnualAllowableCutInventory')
//                    ->join('ForestResources.AnnualAllowableCuts', 'ForestResources.AnnualAllowableCuts.ManagementUnit', 'ForestResources.ManagementUnits.Id')
//                    ->join('ForestResources.ManagementUnits', 'ForestResources.ManagementUnits.DevelopmentUnit',"=", 'ForestResources.DevelopmentUnits.Id')
//                    ->join('ForestResources.DevelopmentUnits', 'ForestResources.Concessions.Id', "",'ForestResources.DevelopmentUnits.Concession')
//                    ->join('ForestResources.Concessions', 'ForestResources.Concessions.Company', '=', 'Taxonomy.Companies.Id')
//                    ->join('Taxonomy.Companies', 'admin.accounts.company_id', '=', 'Taxonomy.Companies.Id')
//                    ->join('admin.accounts', 'admin.accounts.company_id', '=', 'Taxonomy.Companies.Id')
//                    ->select('ForestResources.AnnualAllowableCutInventory.Id','ForestResources.AnnualAllowableCutInventory.LogId')
//                    ->where("admin.accounts.id","=",$userId)
//                    ->get();

        $values->each(function ($value) use (&$array) {
            $array[]= [
                'val' => $value->LogId,
                'id'  => $value->Id,
            ];

        });

        return array($array);
    }
}
