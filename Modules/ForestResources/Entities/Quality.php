<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class Quality extends Model
{
    use Sortable, Loggable, SoftDeletes;

    protected $fillable = ['Value', 'Description', 'User'];

    protected $table = "ForestResources.InventoryQualities";

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;



    protected $primaryKey = "Id";

}
