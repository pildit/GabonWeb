<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class Concession extends Model
{
	use Sortable, Geometry;

	const CREATED_AT = 'CreatedAt';
	const UPDATED_AT = 'UpdatedAt';
	const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'Name', 'Company', 'Geometry', 'Company', 'Continent', 'ResourceType', 'ConstituentPermit'
    ];

    protected $table = "ForestResources.Concessions";

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = "Id";
}
