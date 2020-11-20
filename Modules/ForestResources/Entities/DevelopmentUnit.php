<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DevelopmentUnit extends Model
{
    use Sortable, Geometry, SoftDeletes;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name','Number','User', 'Concession','Start','End','Geometry','Approved'];

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['ConcessionName'];

    /**
     * Concession Name accessor
     */
    public function getConcessionNameAttribute()
    {
        return (isset($this->concession) && $this->concession) ? $this->concession->Name : null;
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

}
