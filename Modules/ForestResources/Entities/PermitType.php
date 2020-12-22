<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class PermitType extends Model
{
    use Sortable, Loggable, SoftDeletes;

    public $timestamps = true;
    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";



    protected $fillable = ['Abbreviation',  'Name', 'User'];

    protected $table = "ForestResources.PermitTypes";

    protected $primaryKey =  "Id";
}
