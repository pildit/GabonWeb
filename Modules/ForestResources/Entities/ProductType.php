<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Modules\Loggable\Traits\Loggable;

class ProductType extends Model
{
    use Sortable, UserEmailAttribute, Loggable;

    protected $guarded = [];

    protected $table = 'Taxonomy.ProductType';

    protected $primaryKey = 'Id';
    protected $dateFormat = 'Y-m-d H:i:s.u';


    const CREATED_AT =  "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    // public $timestamps = true;

}
