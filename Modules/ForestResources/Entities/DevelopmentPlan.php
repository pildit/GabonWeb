<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class DevelopmentPlan extends Model
{
    use SoftDeletes , Sortable, Loggable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['DevelopmentUnit', 'Number', 'Species','MinimumExploitableDiameter','VolumeTariff','Increment','Approved'];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'Approved' => false // default for Approved
    ];

    protected $casts = [
        'MinimumExploitableDiameter' => 'integer'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ForestResources.DevelopmentPlans';

    protected $primaryKey = "Id";

    public function species () {
        return $this->belongsTo(Species::class,'Species');
    }
}
