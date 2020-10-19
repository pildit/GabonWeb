<?php

namespace Modules\ForestResources\Entities;

use App\Services\Sortable;
use Illuminate\Database\Eloquent\Model;

class ManagementUnit extends Model
{
    use Sortable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans()
    {
        return $this->hasMany(ManagementPlan::class);
    }

}
