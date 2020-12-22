<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    protected $primaryKey = 'Id';
    public $timestamps = true;


    protected $fillable = ['User', 'Lat', 'Lon','GpsAccu', 'ObserveAt'];

    protected $table = 'Transportation.PermitTracking';


    public function getGeomAttribute($value)
    {
        return json_decode($value);
    }

    public function permit()
    {
        return $this->belongsTo(Permit::class,"Permit");
    }
}
