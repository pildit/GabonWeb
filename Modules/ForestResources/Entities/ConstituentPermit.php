<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use Brick\Geo\IO\EWKBReader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Sortable;
use Illuminate\Support\Facades\DB;

class ConstituentPermit extends Model
{
	use Sortable, SoftDeletes, Geometry;

    protected $fillable = ['PermitType', 'Geometry', 'PermitNumber', 'Approved'];

    protected $table = 'ForestResources.ConstituentPermits';

    public $timestamps = true;
	protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    protected $hidden = ['PermitType', 'Geometry'];

    public static $snakeAttributes = false;

    protected $appends = ['geometry_as_text'];

    public function getGeometryAsTextAttribute()
    {
        if(!$this->Geometry) return null;
        $reader = new EWKBReader();
        $geom = $reader->read(hex2bin($this->Geometry));
        return $geom->asText();
    }

    public function PermitTypeObj()
    {
        return $this->belongsTo('Modules\ForestResources\Entities\PermitType', 'PermitType');
    }
}
