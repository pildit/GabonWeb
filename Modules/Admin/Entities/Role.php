<?php

namespace Modules\Admin\Entities;

use App\Traits\Sortable;
use Modules\Loggable\Traits\Loggable;
use Modules\User\Entities\EmployeeType;

class Role extends \Spatie\Permission\Models\Role
{
    use Sortable, Loggable;

    protected $fillable = ["name", "type"];

    protected $attributes = [
        'guard_name' => 'api'
    ];

    protected $hidden = ['guard_name'];

    protected $with = ['employee_type'];

    public function employee_type() {
        return $this->belongsTo(EmployeeType::class, 'type');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'admin.page_role');
    }

}
