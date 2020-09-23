<?php


namespace Modules\Transport\Services;


use App\Services\PageResults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    /**
     * Logic from old mobile.php encapsulated
     *
     * @returns json object of the fields for mobile form
     */
    public function getMobileForm()
    {
        list($product_types, $destinations) = $this->productAndDestinationLists();

        list($client_name, $transport_comp, $harvest_name) = $this->companiesList();

        $str ='';
        //field,fieldlabel,type
        // types -> //int,float,str,list,int_NotEmpty,str_NotEmpty,_NoLang


        $str.='{"f":"obsdate","fl":"","type":"date"},';
        $str.='{"f":"appuser","fl":"","type":"str"},';
        $str.='{"f":"mobile_id","fl":"","type":"str"},';
        $str.='{"f":"gps_accu","fl":"","type":"int"},';
        $str.='{"f":"permit_status","fl":"","default":"ready","type":"str"},';
        $str.='{"f":"generated_by","fl":"","type":"str"},';
        $str.='{"f":"verified_by","fl":"","type":"str"},';
        $str.='{"f":"transport_by","fl":"","type":"str"},';
        $str.='{"f":"scan_lat","fl":"","type":"float"},';
        $str.='{"f":"scan_lon","fl":"","type":"float"},';
        $str.='{"f":"scan_gps_accu","fl":"","type":"int"},';
        // group="Location"
        $str.='{"f":"lat","fl":"Lat","type":"float_NotEmpty","group":"Location"},';
        $str.='{"f":"lon","fl":"Long","type":"float","group":"Location"},';

        $str.='{"f":"permit_no","fl":"permit_no","type":"str_NotEmpty"},';
        $str.='{"f":"harvest_name","fl":"harvest_name","type":"list_NotEmpty_NoLang","values":"'.$harvest_name.'"},';
        $str.='{"f":"client_name","fl":"client_name","type":"list_NotEmpty_NoLang","values":"'.$client_name.'"},';
        $str.='{"f":"concession_name","fl":"concession_name","type":"str"},';
        $str.='{"f":"transport_comp","fl":"transport_comp","type":"list_NotEmpty_NoLang","values":"'.$transport_comp.'"},';
        $str.='{"f":"license_plate","fl":"license_plate","type":"str_NotEmpty"},';
        $str.='{"f":"destination","fl":"destination","type":"list_NotEmpty","values":"'.$destinations.'"},';
        $str.='{"f":"management_unit","fl":"management_unit","type":"str"},';
        $str.='{"f":"operational_unit","fl":"operational_unit","type":"str"},';
        $str.='{"f":"annual_operational_unit","fl":"annual_operational_unit","type":"str"},';
        $str.='{"f":"product_type","fl":"product_type","type":"list_NotEmpty","values":"'.$product_types.'"},';
        $str.='{"f":"note","fl":"note","type":"str"}';
        // group="Logs"
        //$str.='{"f":"d1","fl":"Diameter 1 cm","type":"str","group":"Logs"},';
        //$str.='{"f":"d2","fl":"Diameter 2 cm","type":"str","group":"Logs"},';
        //$str.='{"f":"lenght","fl":"Lenght m","type":"str","group":"Logs"},';
        // group="photo"
        //$str.='{"f":"photo1","fl":"","type":"str","group":"photo"},';
        //$str.='{"f":"photo2","fl":"","type":"str","group":"photo"},';

        $str = '['.$str.']';

        return json_decode($str);
    }

    /**
     * Save permit into databse
     *
     * @param $data
     * @return PermitEntity
     */
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

    /**
     * @return string[]
     */
    public function productAndDestinationLists(): array
    {
        $product_types = '';
        $destinations = '';

        $permitList = app('db')
            ->table('transportation.permits_lists')
            ->select('field', 'val')
            ->get();


        $permitList->each(function ($item) use (&$product_types, &$destinations) {
            if ($item->field == 'product_type') {
                if ($product_types != '') {
                    $product_types .= ',';
                }
                $product_types .= $item->val;
            }

            if ($item->field == 'destination') {
                if ($destinations != '') {
                    $destinations .= ',';
                }
                $destinations .= $item->val;
            }
        });
        return array($product_types, $destinations);
    }

    /**
     * @return string[]
     */
    public function companiesList(): array
    {
        $client_name = '';
        $transport_comp = '';
        $harvest_name = '';

        $companies = app('db')
            ->table('transportation.companies')
            ->select('field', 'comp_name')
            ->get();

        $companies->each(function ($company) use (&$client_name, &$transport_comp, &$harvest_name) {
            if (Str::contains($company->field, 'client_name')) {
                if ($client_name != '') {
                    $client_name .= ',';
                }
                $client_name .= $company->comp_name;
            }

            if (Str::contains($company->field, 'transport_comp')) {
                if ($transport_comp != '') {
                    $transport_comp .= ',';
                }
                $transport_comp .= $company->comp_name;
            }

            if (Str::contains($company->field, 'harvest_name')) {
                if ($harvest_name != '') {
                    $harvest_name .= ',';
                }
                $harvest_name .= $company->comp_name;
            }
        });
        return array($client_name, $transport_comp, $harvest_name);
    }
}
