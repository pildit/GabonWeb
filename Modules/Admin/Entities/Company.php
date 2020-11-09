<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class Company extends Model
{
    use Sortable;

    protected $fillable = ['Name'];

    protected $table = 'Taxonomy.Companies';

    protected $with = ['types', 'user'];

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    protected $dateFormat = 'Y-m-d H:i:s.u';

    public function types () {
        return $this->belongsToMany(
            'Modules\Admin\Entities\CompanyType',
            'Taxonomy.CompanyHasTypesTable',
            'CompanyId',
            'CompanyTypeId',
        )->select(['CompanyTypes.Name', 'CompanyTypes.Id']);
    }

    public function user() {
        return $this->belongsTo('Modules\User\Entities\User', 'UserId');
    }
    protected $hidden = ['pivot'];
    protected $primaryKey = "Id";
}
