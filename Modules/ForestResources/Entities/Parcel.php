<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','Geometry'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.Parcels';

    protected $primaryKey = "Id";
}
