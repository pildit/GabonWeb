<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Services\Sortable;

class Concession extends Model
{
	use Sortable;

    protected $fillable = ['Name', 'Company', 'Continent', 'ResourceType', 'ConstituentPermit'];

    protected $table = "ForestResources.Concessions";

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    public $timestamps = false;

    protected $primaryKey = "Id";
}
