<?php

namespace Modules\ForestResources\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;

class PermitType extends Model
{
    use Sortable;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";

    protected $fillable = ['Abbreviation',  'Name', 'UserId'];
    public $timestamps = true;

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
