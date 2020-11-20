<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concession extends Model
{
	use Sortable, Geometry, SoftDeletes;

	const CREATED_AT = 'CreatedAt';
	const UPDATED_AT = 'UpdatedAt';
	const DELETED_AT = 'DeletedAt';

    public $timestamps = true;

    protected $fillable = [
        'Name', 'Company', 'Geometry', 'Continent', 'ConstituentPermit','Approved'
    ];

    protected $table = "ForestResources.Concessions";

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = "Id";

    protected $hidden = ['Geometry'];
}
