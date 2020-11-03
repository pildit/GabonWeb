<?php

namespace Modules\Admin\Entities;

use App\Traits\Sortable;

class Role extends \Spatie\Permission\Models\Role
{
    use Sortable;

    protected $fillable = ["name"];

    protected $attributes = [
        'guard_name' => 'api'
    ];

    protected $hidden = ['created_at', 'updated_at', 'guard_name'];

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'admin.page_role');
    }

}
