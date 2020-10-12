<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class DevelopmentPlan extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['DevelopmentUnit','Species','MinimumExploitableDiameter','VolumeTariff','Increment'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.DevelopmentPlans';

    protected $primaryKey = "Id";

}
