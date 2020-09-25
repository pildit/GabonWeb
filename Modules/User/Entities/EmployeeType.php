<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin.employee_types';
}
