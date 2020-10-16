<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class AnnualAllowableCut extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','ManagementUnit','ManagementPlan','Geometry'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.AnnualAllowableCuts';

    protected $primaryKey = "Id";

}
