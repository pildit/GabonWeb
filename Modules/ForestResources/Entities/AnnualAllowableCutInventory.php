<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class AnnualAllowableCutInventory extends Model
{
    use Sortable, SoftDeletes, Loggable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['AnnualAllowableCut','Species','Quality','Parcel','TreeId','DiameterBreastHeight','Geometry','Lat','Lon','GpsAccu','MobileId','Approved'];

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
    protected $table = 'ForestResources.AnnualAllowableCutInventory';

    protected $primaryKey = "Id";

    public function annual_allowable_cut(){
        return $this->belongsTo(AnnualAllowableCut::class,"AnnualAllowableCut");
    }
    public function species () {
        return $this->belongsTo(Species::class,'Species');
    }
}
