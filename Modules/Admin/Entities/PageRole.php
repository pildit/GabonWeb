<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class PageRole extends Model
{
    protected $table = 'admin.page_role';

    public $timestamps = false;

    protected $fillable = ['page_id', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function permissions()
    {

    }
}
