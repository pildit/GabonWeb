<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcel extends Model
{
    use Sortable, Geometry, SoftDeletes, UserEmailAttribute;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;
    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','Geometry', 'Approved', 'User'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.Parcels';

    protected $hidden = ['user'];

    protected $primaryKey = "Id";
}
