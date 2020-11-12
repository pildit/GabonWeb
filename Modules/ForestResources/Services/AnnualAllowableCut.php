<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\AnnualAllowableCut as AnnualAllowableCutEntity;

class AnnualAllowableCut extends PageResults
{

    /**
     * @param $bbox
     * @return mixed
     */
    public function getVectors($bbox)
    {
        $collection = AnnualAllowableCutEntity::select(['Id', DB::raw('public.ST_AsGeoJSON("Geometry") as geom')])
            ->whereRaw("public.ST_Intersects('Geometry', public.ST_MakeEnvelope($bbox))")->get();

        return $collection->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => $item->geom,
                'properties' => [
                    'id' => $item->Id
                ]
            ];
        });
    }


}
