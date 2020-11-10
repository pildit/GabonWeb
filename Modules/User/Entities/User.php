<?php

namespace Modules\User\Entities;

use App\Traits\Sortable;
use GenTux\Jwt\JwtPayloadInterface;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Company;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements JwtPayloadInterface
{
    use HasRoles, Sortable;

    const STATUS_DISABLED = 0;
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'status', 'activationcode', 'employee_type', 'company_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin.accounts';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['password', 'company'];

    /**
     * @var string[]
     */
    protected $appends = ['company_name'];

    /**
     * @return mixed
     */
    public function getCompanyNameAttribute()
    {
        return $this->attributes['company_name'] = ($this->company) ? $this->company->Name : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


    /**
     * The payload for JWT
     *
     * @return array
     */
    public function getPayload()
    {
        return [
            'iss' => env('APP_URL'),
            'aud' => env('APP_URL'),
            'sub' => $this->id,
            'iat' => time(),
            'nbf' => time(),
            'data' => [
                'id' => $this->id,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'permissions' => $this->getAllPermissions()->pluck('name'),
                'roles' => $this->getRoleNames()
            ]
        ];
    }
}
