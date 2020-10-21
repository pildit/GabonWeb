<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class DevelopmentUnit extends Model
{
    use Sortable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','Concession','Start','End','Geometry'];

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.DevelopmentUnits';

    protected $primaryKey = "Id";

    public function concession()
    {
        return $this->belongsTo(Concession::class,"Concession");
    }

    public function plans()
    {
        return $this->hasMany(DevelopmentPlan::class,"DevelopmentUnit");
    }

}
