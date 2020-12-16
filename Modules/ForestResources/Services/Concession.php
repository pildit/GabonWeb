<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\Concession as ConcessionEntity;

class Concession extends PageResults
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

        $concession_table = (new ConcessionEntity())->getTable();
        $collection = app('db')->table($concession_table)
            ->select(['Id','Number',$geomCol,'CompanyName','Continent','ProductTypeName','ConstituentPermitNumber']);
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
                    'Number' => $item->Number,
                    'ConstituentPermit' => $item->ConstituentPermitNumber,
                    'Company' => $item->CompanyName,
                    'Continent' => $item->Continent,
                    'ProductType' => $item->ProductTypeName
                ]
            ];

            $iterator->next();
        }

        return $results;
    }


}
