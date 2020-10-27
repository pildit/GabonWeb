<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class AnnualAllowableCut extends Model
{
    use Sortable, Geometry;

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
    protected $fillable = ['Name','AacId','ManagementUnit','ManagementPlan','Geometry'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.AnnualAllowableCuts';

    protected $primaryKey = "Id";

    public function mangementunit(){
        $this->belongsTo(ManagementUnit::class,"ManagementUnit");
    }

    public function managementplan(){
        $this->belongsTo(ManagementPlan::class,"ManagementPlan");
    }
}
