<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ForestResources\Http\Controllers\LogbookItemController;

class Logbook extends Model
{
    use Sortable, Geometry, SoftDeletes;

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
    protected $fillable = ['Concession','DevelopmentUnit','ManagementUnit','AnnualAllowableCut','ObserveAt','Approved'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.Logbooks';

    protected $primaryKey = "Id";

    public function items(){
        return $this->hasMany(LogbookItem::class,'Logbook');
    }

    public function concession(){
        return $this->belongsTo(Concession::class,'Concession');
    }

    public function developmentunit(){
        return $this->belongsTo(DevelopmentUnit::class,'DevelopmentUnit');
    }

    public function managementunit(){
        return $this->belongsTo(ManagementUnit::class,'ManagementUnit');
    }

    public function anuualallowablecut(){
        return $this->belongsTo(AnnualAllowableCut::class,'AnnualAllowableCut');
    }
}
