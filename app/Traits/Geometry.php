<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Geometry {


    public function setGeometryAttribute($value)
    {
        $this->attributes['Geometry'] = DB::raw("public.st_geomfromtext('$value', 5223)");
//        $this->attributes['Geometry'] = DB::raw("public.st_transform(public.st_setsrid(public.st_geomfromtext('$value'),4326),5223)");
    }

}
