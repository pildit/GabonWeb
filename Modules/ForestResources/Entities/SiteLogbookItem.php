<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ForestResources\Http\Controllers\SiteLogbookItemItemController;
use Modules\Loggable\Traits\Loggable;

class SiteLogbookItem extends Model
{
    use Sortable, SoftDeletes, Loggable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['SiteLogbook','Species','HewingId','Date','MaxDiameter','MinDiameter','AverageDiameter','Length','Volume','ObserveAt','Approved','MobileId'];

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
    protected $table = 'ForestResources.SiteLogbookItems';

    protected $primaryKey = "Id";

    public function logs(){
        return $this->hasMany(SiteLogbookLog::class,'SiteLogbookItem');
    }
    public function family(){
        return $this->belongsTo(Species::class,'Species');
    }

}
