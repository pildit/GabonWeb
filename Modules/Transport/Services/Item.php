<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
use Modules\Transport\Entities\Item as ItemEntity;

class Item extends PageResults
{

    public function getMobileForm()
    {
        $species = $this->listOfSpecies();

        // formular
        //$tab=$_GET["tab"];
        $str ='';
        //field,fieldlabel,type
        // types -> //int,float,str,list,int_NotEmpty,str_NotEmpty
//        $str.='{"f":"obsdate","fl":"","type":"date"},';
        $str.='{"f":"appuser","fl":"","type":"str"},';
        $str.='{"f":"mobile_id","fl":"","type":"str"},';
//        $str.='{"f":"permit_id","fl":"","type":"str"},';
//	   $str.='{"f":"gps_accu","fl":"","type":"int"},';
        // group="Location"
//	   $str.='{"f":"coord_n","fl":"","type":"float"},';
//	   $str.='{"f":"coord_e","fl":"","type":"float"},';

        $str.='{"f":"trunk_number","fl":"trunk_number","type":"str_NotEmpty","condition":"product_type=logs"},';
        $str.='{"f":"lot_number","fl":"lot_number","type":"str_NotEmpty","condition":"product_type=transformed"},';
        $str.='{"f":"species","fl":"species","type":"list_NotEmpty_NoLang","values":"'.$species.'"},';
        $str.='{"f":"diam1","fl":"diam1","type":"float_NotEmpty","condition":"product_type=logs"},';
        $str.='{"f":"diam2","fl":"diam2","type":"float_NotEmpty","condition":"product_type=logs"},';
        $str.='{"f":"diam_avg","fl":"","type":"int"},';
        $str.='{"f":"length","fl":"length","type":"float_NotEmpty","condition":"product_type=logs,transformed"},';
        $str.='{"f":"width","fl":"width","type":"int_NotEmpty","condition":"product_type=transformed"},';
        $str.='{"f":"height","fl":"height","type":"int_NotEmpty","condition":"product_type=transformed"},';
        $str.='{"f":"volume","fl":"volume","type":"float_NotEmpty","condition":"product_type=logs,transformed"},';
        $str.='{"f":"note","fl":"note","type":"str"}';

        $str = '['.$str.']';

        return json_decode($str);
    }

    /**
     * @return string
     */
    public function listOfSpecies(): string
    {
        $species = '';
        $speciesList = app('db')
            ->table('transportation.list_species')
            ->select('pop_name')
            ->get();

        $speciesList->each(function ($item) use (&$species) {
            if ($species != '') {
                $species .= ',';
            }
            $species .= $item->pop_name;
        });
        return $species;
    }
}
