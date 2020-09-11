<?php


namespace Modules\Transport\Entities;


use Illuminate\Database\Eloquent\Model;

class Permit extends Model
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
    protected $fillable = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'geom' => 'json'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transportation.permits';


}
