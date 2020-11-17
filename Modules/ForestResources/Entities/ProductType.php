<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;

class ProductType extends Model
{
    use Sortable, UserEmailAttribute;

    protected $guarded = [];

    protected $table = 'Taxonomy.ProductType';

    protected $primaryKey = 'Id';

    const CREATED_AT =  "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    public $timestamps = true;

}
