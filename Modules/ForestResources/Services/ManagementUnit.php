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
        $geomCol = DB::raw('public.ST_AsGeoJSON(public.st_transform("Geometry",4256)) as geom');
        $whereIntersects = "public.ST_Intersects(public.st_setsrid(\"Geometry\", {$srid}), public.st_setsrid(public.ST_MakeEnvelope({$bbox}), {$srid}))";
        $collection = ManagementUnitEntity::select(['Id', $geomCol,'Name','DevelopmentUnit','ProductType']);
         if($Id){
             $collection = $collection->where("Id","=",$Id);
         }
        $collection = $collection->whereRaw($whereIntersects)->get();

        return $collection->map(function ($item) {
            $Plans = $item->plans()->get()->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'Species'=> $item->species ? $item->species->CommonName : $item->Species,
                    'GrossVolumeUFG'=> $item->GrossVolumeUFG,
                    'GrossVolumeYear'=> $item->GrossVolumeYear,
                    'YieldVolumeYear'=> $item->YieldVolumeYear,
                    'CommercialVolumeYear'=> $item->CommercialVolumeYear
                ];
            });
            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->Id,
                    'Name' => $item->Name,
                    'DevelopmentUnit' => $item->developmentUnit ? $item->developmentUnit->Name : $item->DevelopmentUnit,
                    'ProductType' => $item->product_type ? $item->product_type->Name : $item->ProductType,
                    'Plans' => $Plans
                ]
            ];
        });
    }


}
