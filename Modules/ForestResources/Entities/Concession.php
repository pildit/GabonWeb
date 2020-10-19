<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class Concession extends Model
{
	use Sortable;
	
    protected $fillable = ['Name', 'Company', 'Continent', 'ResourceType', 'ConstituentPermit'];

    protected $table = "ForestResources.Concessions";

    public $timestamps = false;

    protected $primaryKey = "Id";
}
