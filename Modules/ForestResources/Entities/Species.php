<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Modules\Loggable\Traits\Loggable;

class Species extends Model
{
    use Sortable, UserEmailAttribute, Loggable;

    // protected $guarded = ['Id'];
    protected $fillable = ['Code', 'LatinName', 'CommonName', 'User'];

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $table = "Taxonomy.Species";

    protected $primaryKey =  "Id";

}
