<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.ResourceTypesTable';
}
