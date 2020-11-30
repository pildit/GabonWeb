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
        $collection = AnnualAllowableCutEntity::select(['Id', $geomCol,'Name','AacId','ManagementUnit','ManagementPlan','ProductType'])
            ->whereRaw($whereIntersects)->where("Approved", true);

        if($Id){
            $collection = $collection->where("Id","=",$Id);
        }
        if($Name){
            $collection = $collection->where('Name','ilike',"%".$Name."%")->orWhere('AacId','ilike',"%".$AacId."%");
        }

        $collection = $collection->get();

        return $collection->map(function ($item) {
            $annualoperationplan = $item->annualoperation_plans->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'Species'=> $item->species ? $item->species->CommonName : $item->Species,
                    'ExploitableVolume'=> $item->ExploitableVolume,
                    'NonExploitableVolume'=> $item->NonExploitableVolume,
                    'VolumePerHectare'=> $item->VolumePerHectare,
                    'AverageVolume'=> $item->AverageVolume,
                    'TotalVolume'=> $item->TotalVolume
                ];
            });

            return [
                'type' => 'Feature',
                'geometry' => json_decode($item->geom),
                'properties' => [
                    'id' => $item->Id,
                    'Name' => $item->Name,
                    'ID' => $item->AacId,
                    'ManagementUnit' => $item->managementunit ? $item->managementunit->Name : $item->ManagementUnit,
                    'ManagementPlan' => $item->ManagementPlan,
                    'ProductType' => $item->product_type ? $item->product_type->Name : $item->ProductType,
                    'Plans' => $annualoperationplan
                ]
            ];
        });
    }


}
