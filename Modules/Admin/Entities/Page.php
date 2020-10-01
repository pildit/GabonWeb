<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'admin.pages';

    public $timestamps = false;

    protected $fillable = [];
}
