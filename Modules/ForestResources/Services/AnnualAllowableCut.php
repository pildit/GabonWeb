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
    public function getVectors($bbox,$Name)
    {
        $srid = config('forestresources.srid');
        $geomCol = DB::raw('public.ST_AsGeoJSON(public.st_flipcoordinates(public.st_transform("Geometry",4256))) as geom');
        $whereIntersects = "public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))";
        $collection = AnnualAllowableCutEntity::select(['Id', $geomCol])
            ->whereRaw($whereIntersects);

        if($Name){
            $collection = $collection->where('Name','=',$Name)->orWhere('AacId','=',$Name);
        }

        $collection = $collection->get();

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
