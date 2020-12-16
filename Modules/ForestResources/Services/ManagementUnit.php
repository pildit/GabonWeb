<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\ManagementUnit as ManagementUnitEntity;

class ManagementUnit extends PageResults
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
        $collection = ManagementUnitEntity::select(['Id', $geomCol,'Name','DevelopmentUnit','ProductType']);
        $mu_table = (new ManagementUnitEntity())->getTable();
        $collection = app('db')->table($mu_table)
            ->select(['Id', $geomCol,'Name','DevelopmentUnitName','ProductTypeName', 'PlansList']);

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
                    'DevelopmentUnit' => $item->DevelopmentUnitName,
                    'ProductType' => $item->ProductTypeName,
                    'Plans' => $item->PlansList
                ]
            ];

            $iterator->next();
        }

        return $results;
    }


}
