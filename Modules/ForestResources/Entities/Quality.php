<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Modules\Loggable\Traits\Loggable;

class Quality extends Model
{
    use Sortable, UserEmailAttribute, Loggable;

    protected $fillable = ['Value', 'Description', 'User'];

    protected $table = "ForestResources.InventoryQualities";

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = "Id";

}
