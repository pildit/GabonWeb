<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Sortable;

class ConstituentPermit extends Model
{
	use Sortable, SoftDeletes;
	
    protected $fillable = ['User', 'PermitType', 'PermitNumber'];

    protected $table = 'ForestResources.ConstituentPermits';

    public $timestamps = false;

    protected $primaryKey = 'Id';


}
