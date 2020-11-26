<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentPlan extends Model
{
    use SoftDeletes , Sortable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['DevelopmentUnit','Species','MinimumExploitableDiameter','VolumeTariff','Increment','Approved'];

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.DevelopmentPlans';

    protected $primaryKey = "Id";

    public function species () {
        return $this->belongsTo(Species::class,'Species');
    }
}
