<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Sortable;

class ConstituentPermit extends Model
{
	use Sortable, SoftDeletes;
	
    protected $fillable = ['PermitType', 'PermitNumber'];

    protected $table = 'ForestResources.ConstituentPermits';

    public $timestamps = true;
	protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';
}
