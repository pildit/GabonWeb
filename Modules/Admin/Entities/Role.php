<?php

namespace Modules\Admin\Entities;

use App\Services\Sortable;

class Role extends \Spatie\Permission\Models\Role
{
    use Sortable;

    protected $fillable = ["name"];

    protected $attributes = [
        'guard_name' => 'api'
    ];

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'admin.page_role');
    }

}
