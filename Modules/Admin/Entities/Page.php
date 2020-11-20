<?php

namespace Modules\Admin\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sortable;

    protected $table = 'admin.pages';

    public $timestamps = false;

    protected $fillable = [];
}
