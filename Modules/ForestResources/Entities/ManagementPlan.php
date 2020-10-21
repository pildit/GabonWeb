<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class ManagementPlan extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ManagementUnit','Species','GrossVolumeUFG','GrossVolumeYear','YieldVolumeYear','CommercialVolumeYear'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.ManagementPlans';

    protected $primaryKey = "Id";

}
