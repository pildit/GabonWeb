<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class ParkType extends Model
{
    protected $fillable = [];

    protected $table = 'Transportation.ParkTypes';

    public $timestamps = false;

    protected $hidden = ['pivot'];

    protected $primaryKey = "Id";

}
