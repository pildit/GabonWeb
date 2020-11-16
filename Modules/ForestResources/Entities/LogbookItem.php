<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogbookItem extends Model
{
    use Sortable, Geometry, SoftDeletes;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;
    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Logbook','TreeId','HewingId','Species','MaxDiameter','MinDiameter','Length','Volume','Lat','Lon','GpsAccu','Note','ObserveAt','Approved'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.LogbookItems';

    protected $primaryKey = "Id";


}
