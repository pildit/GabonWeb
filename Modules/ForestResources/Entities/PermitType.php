<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class PermitType extends Model
{
    use Sortable;

    protected $fillable = ['Abbreviation',  'Name'];
    public $timestamps = false;

    protected $table = "ForestResources.PermitTypes";

    protected $primaryKey =  "Id";
}
