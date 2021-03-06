<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use Brick\Geo\IO\EWKBReader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Sortable;
use Illuminate\Support\Facades\DB;
use Modules\Loggable\Traits\Loggable;

class ConstituentPermit extends Model
{
	use Sortable, SoftDeletes, Geometry, Loggable;

    protected $fillable = ['PermitType', 'Geometry', 'PermitNumber','Concession', 'Approved'];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'Approved' => false // default for Approved
    ];

    protected $table = 'ForestResources.ConstituentPermits';



    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    protected $hidden = ['Geometry'];

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

    public function permit_type()
    {
        return $this->belongsTo('Modules\ForestResources\Entities\PermitType', 'PermitType');
    }

    public function concession(){
        return $this->hasOne('Modules\ForestResources\Entities\Concession', 'Id');
    }
}
