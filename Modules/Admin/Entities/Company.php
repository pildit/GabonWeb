<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use App\Traits\UserEmailAttribute;

class Company extends Model
{
    use Sortable, UserEmailAttribute;

    protected $fillable = ['Name', 'GroupName', 'TradeRegister'];

    protected $table = 'Taxonomy.Companies';

    protected $with = ['types'];

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    protected $dateFormat = 'Y-m-d H:i:s.u';

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
