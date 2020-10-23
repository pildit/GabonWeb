<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];

    protected $table = 'Taxonomy.companies';
    
    public $timestamps = false;

}
