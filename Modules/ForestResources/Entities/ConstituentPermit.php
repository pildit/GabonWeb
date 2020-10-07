<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class ConstituentPermit extends Model
{
	use Sortable;
	
    protected $fillable = ['email', 'permit_type', 'permit_no'];

    protected $table = 'ConstituentPermits';
}
