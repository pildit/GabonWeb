<?php


namespace Modules\ForestResources\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Modules\ForestResources\Entities\ConstituentPermit as ConstituentPermitEntity;

class ConstituentPermit extends PageResults
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
        $collection = ConstituentPermitEntity::select(['Id', $geomCol,'PermitType','PermitNumber']);
          if($Id){
              $collection = $collection->where("Id","=",$Id);
          }
        $collection = $collection->whereRaw($whereIntersects)->where("Approved", true)->get();

        return $collection->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->Id,
                    'PermitType' => $item->PermitType,
                    'PermitNumber' => $item->PermitNumber
                ]
            ];
        });
    }


}
