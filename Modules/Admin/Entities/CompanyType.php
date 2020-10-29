<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $fillable = [];

    protected $table = 'Taxonomy.CompanyTypes';

    public $timestamps = false;

    protected $hidden = ['pivot'];

    protected $primaryKey = "Id";

    public function companies() {
        return $this->belongsToMany(
            'Modules\Admin\Entities\Company',
            'Taxonomy.CompanyHasTypesTable',
            'CompanyTypeId',
            'CompanyId'
        );
    }


}
