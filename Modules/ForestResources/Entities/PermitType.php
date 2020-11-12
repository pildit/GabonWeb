<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class PermitType extends Model
{
    use Sortable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $fillable = ['Abbreviation',  'Name', 'UserId'];

    protected $table = "ForestResources.PermitTypes";

    protected $primaryKey =  "Id";

    protected $appends = ['Email'];

    public function getEmailAttribute()
    {
        return $this->attributes['Email'] = ($this->user) ? $this->user->email : null;
    }

    public function user() {
        return $this->belongsTo('Modules\User\Entities\User', 'UserId');
    }

    protected $hidden = ['user'];

}
