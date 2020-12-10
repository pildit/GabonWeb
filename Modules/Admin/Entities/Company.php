<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Loggable\Traits\Loggable;

class Company extends Model
{
    use Sortable, UserEmailAttribute, Loggable, SoftDeletes;

    protected $fillable = ['Name', 'GroupName', 'TradeRegister', 'DeletedAt'];

    protected $table = 'Taxonomy.Companies';

    protected $with = ['types'];

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    public function types () {
        return $this->belongsToMany(
            'Modules\Admin\Entities\CompanyType',
            'Taxonomy.CompanyHasTypesTable',
            'CompanyId',
            'CompanyTypeId'
        )->select(['CompanyTypes.Name', 'CompanyTypes.Id']);
    }

    protected $hidden = ['pivot', 'user'];
    protected $primaryKey = "Id";
}
