<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\Parcel as ParcelEntity;

class Parcel extends PageResults
{

    /**
     * @param $bbox
     * @return mixed
     */
    public function getVectors($bbox)
    {
        $srid = config('forestresources.srid');
        $geomCol = DB::raw('public.ST_AsGeoJSON(public.st_transform("Geometry",4256)) as geom');
        $whereIntersects = "public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))";
        $collection = ParcelEntity::select(['Id', $geomCol])
            ->whereRaw($whereIntersects)->get();

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
