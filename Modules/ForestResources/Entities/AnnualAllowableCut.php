<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Brick\Geo\IO\EWKBReader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class AnnualAllowableCut extends Model
{
    use Sortable, Geometry, SoftDeletes, Loggable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','AacId','ManagementUnit','ManagementPlan','Geometry','Approved', 'ProductType'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.AnnualAllowableCuts';

    protected $hidden = ['Geometry'];

    protected $appends = ['geometry_as_text', 'management_plans'];

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

    protected $primaryKey = "Id";

    public function management_unit(){
        return $this->belongsTo(ManagementUnit::class,"ManagementUnit");
    }

    public function getManagementPlansAttribute() {
        if($this->management_unit) {
            return collect($this->management_unit->plans)->merge([$this->management_plan]);
        }
    }

    public function management_plan(){
        return $this->belongsTo(ManagementPlan::class,"ManagementPlan");
    }

    public function annualoperation_plans(){
        return $this->hasMany(AnnualOperationPlan::class,"AnnualAllowableCut","Id");
    }

    public function product_type(){
        return $this->belongsTo(ProductType::class,"ProductType");
    }
}
