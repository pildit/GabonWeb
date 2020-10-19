<?php

namespace Modules\ForestResources\Entities;

use App\Services\Sortable;
use Illuminate\Database\Eloquent\Model;

class DevelopmentUnit extends Model
{
    use Sortable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

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

    public function concession()
    {
        return $this->hasOne(Concession::class);
    }

    public function plans()
    {
        return $this->hasMany(DevelopmentPlan::class);
    }

}
