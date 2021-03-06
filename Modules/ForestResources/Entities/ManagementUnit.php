<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class ManagementUnit extends Model
{
    use Sortable, Geometry, SoftDeletes, Loggable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','Number', 'User', 'ProductType', 'DevelopmentUnit','Geometry','Approved'];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'Approved' => false // default for Approved
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.ManagementUnits';

    protected $primaryKey = "Id";

    protected $hidden = ['Geometry'];

    protected $appends = ['plans_count'];

    public function getPlansCountAttribute()
    {
        $plans = collect($this->plans);
        return $plans->count();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans()
    {
        return $this->hasMany(ManagementPlan::class,"ManagementUnit");
    }

    public function developmentUnit()
    {
        return $this->belongsTo(DevelopmentUnit::class,"DevelopmentUnit");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product_type()
    {
        return $this->belongsTo(ProductType::class, "ProductType");
    }

}
