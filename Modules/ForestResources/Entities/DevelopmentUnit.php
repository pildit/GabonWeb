<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Brick\Geo\IO\EWKBReader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class DevelopmentUnit extends Model
{
    use Sortable, Geometry, SoftDeletes, Loggable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','Number','User', 'ProductType', 'Concession','Start','End','Geometry','Approved'];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'Approved' => false // default for Approved
    ];

    protected $appends = ['geometry_as_text', 'plans_count'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.DevelopmentUnits';

    /**
     * @var string
     */
    protected $primaryKey = "Id";

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var string[]
     */
    protected $hidden = ['Geometry'];

    public function getGeometryAsTextAttribute()
    {
        if(!$this->Geometry) return null;

        if(ctype_xdigit($this->Geometry)) {
            $reader = new EWKBReader();
            $geom = $reader->read(hex2bin($this->Geometry));
            return $geom->asText();
        }else{
            return $this->Geometry;
        }
    }

    public function getPlansCountAttribute()
    {
        $plans = collect($this->plans);
        return $plans->count();
    }

    /**
     * Concession relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concession()
    {
        return $this->belongsTo(Concession::class,"Concession");
    }

    /**
     * Developtment Plans realtion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans()
    {
        return $this->hasMany(DevelopmentPlan::class,"DevelopmentUnit");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product_type()
    {
        return $this->belongsTo(ProductType::class, "ProductType");
    }

}
