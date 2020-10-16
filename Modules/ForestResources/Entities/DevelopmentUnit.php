<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class DevelopmentUnit extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','Concession','Start','End','Geometry'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.DevelopmentUnits';

    protected $primaryKey = "Id";
}
