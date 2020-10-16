<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class ManagementUnit extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','DevelopmentUnit','Geometry'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.ManagementUnits';

    protected $primaryKey = "Id";
}