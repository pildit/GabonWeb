<?php

namespace Modules\Loggable\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LogEntry extends Model
{
    public $timestamps = false;

    protected $table = 'public.log_entries';

    protected $fillable = ['action', 'logged_at', 'object_id', 'object_class', 'user_id', 'data', 'version', 'original_data'];

    protected $dates = ['logged_at'];

    /**
     * The watched model
     *
     * @return MorphTo
     */
    public function loggable()
    {
        return $this->morphTo();
    }

    /**
     * The user who save this revision
     *
     * @return BelongsTo
     */
    public function user()
    {
        $className = config('auth.model');

        return $this->belongsTo($className);
    }
}
