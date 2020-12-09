<?php

namespace Modules\ForestResources\Entities;

use App\Traits\Geometry;
use Brick\Geo\IO\EWKBReader;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Entities\Company;
use Modules\Loggable\Traits\Loggable;

class Concession extends Model
{
	use Sortable, Geometry, SoftDeletes, Loggable;

	const CREATED_AT = 'CreatedAt';
	const UPDATED_AT = 'UpdatedAt';
	const DELETED_AT = 'DeletedAt';

    public $timestamps = true;

    protected $fillable = [
        'Number', 'Name', 'Company', 'Geometry', 'ProductType', 'Continent', 'ConstituentPermit','Approved', 'User'
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'Approved' => false // default for Approved
    ];

    protected $table = "ForestResources.Concessions";

    protected $with = ['constituent_permit:Id,PermitNumber'];

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = "Id";

    protected $hidden = ['Geometry'];

    protected $appends = ['geometry_as_text'];

    public function getGeometryAsTextAttribute()
    {
        if(!$this->Geometry) return null;

        if(ctype_xdigit($this->Geometry)) {
            $reader = new EWKBReader();
            $geom = $reader->read(hex2bin($this->Geometry));
            return $geom->asText();
        }else{
            return $this->Geometry;
        }
    }

    public function constituent_permit()
    {
        return $this->belongsTo(ConstituentPermit::class, 'ConstituentPermit');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'Company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_type()
    {
        return $this->belongsTo(ProductType::class, "ProductType");
    }
}
