<?php


namespace Modules\Transport\Services;


use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Transport\Entities\Permit as PermitEntity;

class Permit extends PageResults
{
    /**
     * @return mixed
     */
    public function getPaginator()
    {

        $data = PermitEntity::ofSort($this->getSortCriteria())
            ->paginate($this->per_page);
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
