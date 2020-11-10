<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    protected $primaryKey = 'Id';
    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $fillable = ['User', 'Lat', 'Lon','GpsAccu', 'ObserveAt'];

    protected $table = 'transportation.PermitTracking';


    public function getGeomAttribute($value)
    {
        return json_decode($value);
    }

}
