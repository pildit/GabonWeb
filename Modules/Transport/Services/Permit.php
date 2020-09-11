<?php


namespace Modules\Transport\Services;


use Illuminate\Support\Facades\DB;
use Modules\Transport\Entities\Permit as PermitEntity;

class Permit extends PageResults
{
    /**
     * @return mixed
     */
    public function getPaginator()
    {
        $data = PermitEntity::orderBy($this->getOrderBy(), $this->getOrderDirection())
            ->paginate(50);
        return $data;
    }

    /**
     * @param $bbox
     * @return mixed
     */
    public function getVectors($bbox)
    {
        $collection = PermitEntity::select(['id', DB::raw('ST_AsGeoJSON(the_geom) as geom')])
            ->whereRaw("ST_Intersects(the_geom, ST_MakeEnvelope($bbox))")->get();

        return $collection->map(function ($item) {
            return [
                'type' => 'Feature',
                'geometry' => $item->geom,
                'properties' => [
                    'id' => $item->id
                ]
            ];
        });
    }
}
