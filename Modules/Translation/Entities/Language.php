<?php

namespace Modules\Translation\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Modules\Loggable\Traits\Loggable;

class Language extends Model
{
    use Sortable, Loggable;

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
    protected $fillable = [
        'text_key', 'text_us', 'text_ga', 'mobile', 'appuser'
    ];
}
