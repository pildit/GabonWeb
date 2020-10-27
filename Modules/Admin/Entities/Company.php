<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class Company extends Model
{
    use Sortable;

    protected $fillable = ['Name'];

    protected $table = 'Taxonomy.Companies';

    protected $with = ['types:Name'];

    public $timestamps = false;

    public function types () {
        return $this->belongsToMany(
            'Modules\Admin\Entities\CompanyType',
            'Taxonomy.CompanyHasTypesTable',
            'CompanyId',
            'CompanyTypeId',
        );
    }
    protected $hidden = ['pivot'];
    protected $primaryKey = "Id";
}
