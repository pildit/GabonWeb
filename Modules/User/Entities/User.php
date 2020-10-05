<?php

namespace Modules\User\Entities;

use GenTux\Jwt\JwtPayloadInterface;
use Illuminate\Database\Eloquent\Model;
use App\Services\PageResults;
use Spatie\Permission\Traits\HasRoles;
use Modules\Loggable\Traits\Loggable;

class User extends Model implements JwtPayloadInterface
{
    use HasRoles;

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
            ]
        ];
    }

    /**
     * @param $query
     * @param $sort
     */
    // TODO : move into trait
    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }

    public function company()
    {
        return $this->belongsTo('Modules\User\Entities\Company');
    }
}
