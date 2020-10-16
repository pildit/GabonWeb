<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];

    protected $table = 'admin.companies';
    
    public $timestamps = false;

}
