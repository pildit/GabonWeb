<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "trunk_number", "lot_number", "species",
        "diam1", "diam2", "length", "volume", "width", "height", "mobile_id",
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transportation.permit_items';

    /**
     * @param $query
     * @param $sort
     */
    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permit()
    {
        return $this->belongsTo(Permit::class);
    }
}
