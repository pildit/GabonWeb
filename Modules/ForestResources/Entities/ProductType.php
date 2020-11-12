<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class ProductType extends Model
{
    use Sortable;

    protected $fillable = ['Name'];
    protected $table = 'Taxonomy.ProductType';

    protected $primaryKey = 'Id';

    const CREATED_AT =  "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

}
