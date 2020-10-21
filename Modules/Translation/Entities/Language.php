<?php

namespace Modules\Translation\Entities;

use App\Services\Sortable;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use Sortable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tools.languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}
