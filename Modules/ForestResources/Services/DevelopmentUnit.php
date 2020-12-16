<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\DevelopmentUnit as DevelopmentUnitEntity;

class DevelopmentUnit extends PageResults
{

    /**
     * @param $bbox
     * @return mixed
     */
    public function getVectors($bbox,$Id)
    {
        $srid = config('forestresources.srid');
        $geomCol = DB::raw('public.ST_AsGeoJSON(public.st_transform(public.st_setsrid("Geometry",'.$srid.'),4326)) as geom');
        $whereIntersects = "public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))";

        $du_table = (new DevelopmentUnitEntity())->getTable();
        $collection = app('db')->table($du_table)
            ->select(['Id', $geomCol,'Name', 'ConcessionName','ProductTypeName','Start','End', 'PlansList']);

        if($Id){
           $collection = $collection->where("Id","=",$Id);
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
                    'Concession' => $item->ConcessionName,
                    'ProductType' => $item->ProductTypeName,
                    'Start' => $item->Start,
                    'End' => $item->End,
                    'Plans' => $item->PlansList
                ]
            ];

            $iterator->next();
        }
        return $results;

    }


}
