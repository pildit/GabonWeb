<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class TransportType extends Model
{
    protected $fillable = [];

    protected $table = 'Transportation.TransportTypes';

    public $timestamps = false;

    protected $hidden = ['pivot'];

    protected $primaryKey = "Id";

}
