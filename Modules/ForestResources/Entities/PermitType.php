<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;

class PermitType extends Model
{
    use Sortable, UserEmailAttribute;

    public $timestamps = true;
    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['Abbreviation',  'Name', 'UserId'];

    protected $table = "ForestResources.PermitTypes";

    protected $primaryKey =  "Id";
}
