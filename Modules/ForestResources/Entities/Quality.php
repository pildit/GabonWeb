<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;

class Quality extends Model
{
    use Sortable, UserEmailAttribute;

    protected $fillable = ['Value', 'Description', 'UserId'];

    protected $table = "ForestResources.InventoryQualities";

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = "Id";

}
