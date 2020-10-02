<?php

namespace Modules\Admin\Entities;

use App\Services\Sortable;
use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    use Sortable;

    const VIEW = 'view';
    const VIEW_OWN = 'view_own';
    const CREATE = 'create';
    const EDIT = 'edit';
    const EDIT_OWN = 'edit_own';

    public static $choices = [
        self::VIEW,
        self::VIEW_OWN,
        self::CREATE,
        self::EDIT,
        self::EDIT_OWN
    ];

    protected $fillable = ["name"];

    protected $attributes = [
        'guard_name' => 'api'
    ];

    protected $hidden = ['created_at', 'updated_at', 'guard_name'];
}
