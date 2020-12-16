<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\AnnualAllowableCut as AnnualAllowableCutEntity;


class AnnualAllowableCut extends PageResults
{


    /**
     * @param $bbox
     * @param $Name
     * @param $AacId
     * @param $Id
     * @return mixed
     */
    public function getVectors($bbox,$Name,$AacId,$Id)
    {
        $srid = config('forestresources.srid');
        $geomCol = DB::raw('public.ST_AsGeoJSON(public.st_transform(public.st_setsrid("Geometry",'.$srid.'),4326)) as geom');
        $whereIntersects = "public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))";

        $aac_table = (new AnnualAllowableCutEntity())->getTable();
        $collection = app('db')->table($aac_table)
            ->select(['Id', $geomCol,'Name','AacId','ManagementUnitName','ManagementPlan','ProductTypeName', 'PlansList']);

        if($Id){
            $collection = $collection->where("Id","=",$Id);
        }
        if($Name){
            $collection = $collection->where('Name','ilike',"%".$Name."%")->orWhere('AacId','ilike',"%".$AacId."%");
        }

        $collection = $collection->whereRaw($whereIntersects)->get();
        $obj = new \ArrayObject($collection->all());
        $iterator = $obj->getIterator();

        $results = [];
        while ($iterator->valid()) {
            $item = $iterator->current();

            $results[] = [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->Id,
                    'Name' => $item->Name,
                    'ID' => $item->AacId,
                    'ManagementUnit' => $item->ManagementUnitName,
                    'ManagementPlan' => $item->ManagementPlan,
                    'ProductType' => $item->ProductTypeName,
                    'Plans' => $item->PlansList
                ]
            ];

            $iterator->next();
        }

        return $results;
    }


}
