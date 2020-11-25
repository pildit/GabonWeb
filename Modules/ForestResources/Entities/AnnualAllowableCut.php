<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnualAllowableCut extends Model
{
    use Sortable, Geometry, SoftDeletes;

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
    protected $fillable = ['Name','AacId','ManagementUnit','ManagementPlan','Geometry','Approved'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.AnnualAllowableCuts';

    protected $primaryKey = "Id";

    public function managementunit(){
        return $this->belongsTo(ManagementUnit::class,"ManagementUnit");
    }

    public function managementplan(){
        return $this->belongsTo(ManagementPlan::class,"ManagementPlan");
    }

    public function annualoperationplans(){
        return $this->hasMany(AnnualOperationPlan::class,"AnnualAllowableCut","Id");
    }

    public function producttype(){
        return $this->belongsTo(ProductType::class,"ProductType");
    }
}
