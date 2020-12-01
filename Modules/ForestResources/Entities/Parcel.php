<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Brick\Geo\IO\EWKBReader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class Parcel extends Model
{
    use Sortable, Geometry, SoftDeletes, UserEmailAttribute, Loggable;

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
    protected $fillable = ['Name','Geometry', 'Approved', 'User'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.Parcels';

    protected $hidden = ['user'];

    protected $primaryKey = "Id";

    protected $appends = ['geometry_as_text'];

    public function getGeometryAsTextAttribute()
    {
        if(!$this->Geometry) return null;

        if(ctype_xdigit($this->Geometry)) {
            $reader = new EWKBReader();
            $geom = $reader->read(hex2bin($this->Geometry));
            return $geom->asText();
        }else{
            return $this->Geometry;
        }
    }
}
