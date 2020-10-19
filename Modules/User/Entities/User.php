<?php

namespace Modules\User\Entities;

use App\Services\Sortable;
use GenTux\Jwt\JwtPayloadInterface;
use Illuminate\Database\Eloquent\Model;
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
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'activationcode', 'employee_type', 'company_id'];

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
    protected $hidden = ['password'];


    /**
     * The payload for JWT
     *
     * @return array
     */
    public function getPayload()
    {
        $permissions = [];
        // to be improved
        $this->roles->each(function ($role) use (&$permissions) {
            $permissions = array_unique(array_merge($permissions, $role->getPermissionNames()->toArray()));
        });

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
                'permissions' => $permissions,
                'roles' => $this->getRoleNames()
            ]
        ];
    }
}
