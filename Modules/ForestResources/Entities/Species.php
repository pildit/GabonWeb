<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class Species extends Model
{
    use Sortable;

    // protected $guarded = ['Id'];
    protected $fillable = ['Code', 'LatinName', 'CommonName'];

    protected $table = "Taxonomy.Species";
    public $timestamps = false;

    protected $primaryKey =  "Id";

}
