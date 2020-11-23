<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use GenTux\Jwt\GetsJwtToken;
use Modules\ForestResources\Entities\Logbook;

class SiteLogbookItem extends PageResults
{
    use GetsJwtToken;
    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {

        list($HewingId) = $this->hewingIdLists();
        list($species) = $this->speciesLists();
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
                "type" => "list_ed_NotEmpty_NoLang",
                "values" => $HewingId
            ],
            [
                "f" => "Species",
                "fl" => "Species",
                "type" => "list_NotEmpty_NoLang",
                "values" => $species
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
                "f" => "Date",
                "fl" => "Date",
                "type" => "date_NotEmpty"
            ],


        ];


        return $formArr;
    }


    public function hewingIdLists(): array
    {
        $array = [];

        $userId = $this->jwtPayload('data.id');

        $concessions =  DB::table('admin.accounts')
            ->join('Taxonomy.Companies', 'admin.accounts.company_id', '=', 'Taxonomy.Companies.Id')
            ->join('ForestResources.Concessions', 'ForestResources.Concessions.Company', '=', 'Taxonomy.Companies.Id')
            ->select('ForestResources.Concessions.Id')
            ->where("admin.accounts.id","=", $userId)->get()->toArray();

        $concessions = array_column($concessions, 'Id');


        $Logbooks = DB::table('ForestResources.Logbooks')
            ->select('ForestResources.Logbooks.Id')
            ->whereIn("ForestResources.Logbooks.Concession",$concessions)->get();


        $Logbooks->each(function ($Logbook) use (&$array) {
            $Logbook = Logbook::find($Logbook->Id);
            $Logbook->items()->get()->each(function ($value) use (&$array) {
                $array[]= [
                    'val' => $value->HewingId,
                ];
            });
        });

        return array($array);
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
