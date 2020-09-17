<?php


namespace Modules\Transport\Entities;


use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["obsdate", "lat", "lon", "gps_accu", "permit_no", "harvest_name",
        "client_name", "concession_name", "transport_comp", "license_plate", "note",
        "destination", "management_unit", "operational_unit", "annual_operational_unit",
        "the_geom", "product_type", "permit_status"];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'geom' => 'json'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transportation.permits';


    /**
     * @param $query
     * @param $sort
     */
    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }
}
