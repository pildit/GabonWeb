<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class ProductType extends Model
{
    use Sortable, UserEmailAttribute, Loggable, SoftDeletes;

    protected $guarded = [];

    protected $table = 'Taxonomy.ProductType';

    protected $primaryKey = 'Id';
    protected $dateFormat = 'Y-m-d H:i:s.u';


    const CREATED_AT =  "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    // public $timestamps = true;

}
