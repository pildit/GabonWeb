<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class AnnualOperationPlan extends Model
{
    use Sortable;

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
    protected $fillable = ['AnnualAllowableCut','Species','ExploitableVolume','NonExploitableVolume','VolumePerHectare','AverageVolume','TotalVolume'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.AnnualOperationPlans';

    protected $primaryKey = "Id";

}
