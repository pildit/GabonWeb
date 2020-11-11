<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class Quality extends Model
{
    use Sortable;

    protected $fillable = ['Value', 'Description'];

    protected $table = "Taxonomy.Quality";

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = "Id";

}
