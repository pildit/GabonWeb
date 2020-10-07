<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Tracking extends Model
{
    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    protected $primaryKey = 'Id';

    protected $fillable = ['User', 'Geometry'];

    protected $table = 'transportation.PermitTracking';

}
