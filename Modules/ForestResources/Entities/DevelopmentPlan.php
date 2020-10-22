<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class DevelopmentPlan extends Model
{
    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['DevelopmentUnit','Species','MinimumExploitableDiameter','VolumeTariff','Increment'];

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

}
