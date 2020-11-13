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
    public function getVectors($bbox)
    {
        $srid = config('forestresources.srid');
        $collection = ConcessionEntity::select(['Id', DB::raw('public.ST_AsGeoJSON("Geometry") as geom')])
            ->whereRaw("public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))")->get();

        return $collection->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->Id
                ]
            ];
        });
    }


}
