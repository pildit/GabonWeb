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

    public function store($data)
    {
        $permit = new PermitEntity();

        $permit->obsdate = $data['obsdate'];
        $permit->lat = $data['lat'];
	    $permit->lon = $data['lon'];
	    $permit->gps_accu = $data['gps_accu'];
	    $permit->permit_no = $data['permit_no'];
	    $permit->harvest_name = $data['harvest_name'];
	    $permit->client_name = $data['client_name'];
	    $permit->concession_name = $data['concession_name'];
	    $permit->transport_comp = $data['transport_comp'];
	    $permit->license_plate = $data['license_plate'];
	    $permit->destination = $data['destination'];
	    $permit->management_unit = $data['management_unit'];
	    $permit->operational_unit = $data['operational_unit'];
	    $permit->annual_operational_unit = $data['annual_operational_unit'];
	    $permit->note = $data['note'] ?? null;
	    $permit->the_geom = $data['the_geom'];
	    $permit->product_type = $data['product_type'];
	    $permit->permit_status = $data['permit_status'];

	    $permit->save();

	    return $permit;
    }
}
