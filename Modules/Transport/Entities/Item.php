<?php

namespace Modules\Transport\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ForestResources\Entities\Species;
use Modules\Loggable\Traits\Loggable;

class Item extends Model
{

    use Sortable, SoftDeletes, Loggable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "Permit",
        "LogId",
        "Species",
        "MinDiameter",
        "MaxDiameter",
        "AverageDiameter",
        "Length",
        "Volume",
        "MobileId"
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Transportation.PermitItems';

    protected $primaryKey = "Id";

    /**
     * @param $query
     * @param $sort
     */
    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permit()
    {
        return $this->belongsTo(Permit::class,"Permit");
    }

    public function species()
    {
        return $this->belongsTo(Species::class,"Species");
    }
}
