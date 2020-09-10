<?php

namespace Modules\User\Entities;

use GenTux\Jwt\JwtPayloadInterface;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements JwtPayloadInterface
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'password'];

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
                'role' => $this->roles->pluck('role')->join(',')
            ]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'email', 'email')
            ->select('role', 'email');
    }
}
