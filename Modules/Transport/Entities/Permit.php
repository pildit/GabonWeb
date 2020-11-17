<?php


namespace Modules\Transport\Entities;


use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Entities\Company;
use Modules\ForestResources\Entities\AnnualAllowableCut;
use Modules\ForestResources\Entities\Concession;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\ManagementUnit;
use Modules\User\Entities\User;

class Permit extends Model
{

    use Sortable, SoftDeletes;

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    const DELETED_AT = "DeletedAt";

    /**
     * ProductType
     */
    const PRODUCT_TYPE_LOG = '1';
    public static $PRODUCT_TYPES = [
        'Log'  => self::PRODUCT_TYPE_LOG,
    ];

    /**
     * Statuses
     */
    const STATUS_GENERATED = '1';
    const STATUS_IN_PROGRESS = '2';
    const STATUS_FINISHED = '3';
    public static $STATUSES = [
        'Generated'  => self::STATUS_GENERATED,
        'In progress'  => self::STATUS_IN_PROGRESS,
        'Finished'  => self::STATUS_FINISHED,
    ];


    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "PermitNo",
        "PermitNoMobile",
        "Concession",
        "ManagementUnit",
        "DevelopmentUnit",
        "AnnualAllowableCut",
        "ClientCompany",
        "ConcessionaireCompany",
        "TransporterCompany",
        "User",
        "ProductType",
        "Status",
        "DriverName",
        "LicensePlate",
        "Province",
        "Destination",
        "ScanLat",
        "ScanLon",
        "ScanGpsAccu",
        "Lat",
        "Lon",
        "GpsAccu",
        "Geometry",
        "MobileId",
        "ObserveAt"];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'Geom' => 'json'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Transportation.Permits';

    protected $primaryKey = "Id";

    /**
     * @param $query
     * @param $sort
     */
    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }

    /**
     * Items / trees
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'Permit');
    }

    public function concession(){
        return $this->belongsTo(Concession::class,"Concession");
    }
    public function managementunit(){
        return $this->belongsTo(ManagementUnit::class,"ManagementUnit");
    }
    public function developmentunit(){
        return $this->belongsTo(DevelopmentUnit::class,"DevelopmentUnit");
    }
    public function annualallowablecut(){
        return $this->belongsTo(AnnualAllowableCut::class,"AnnualAllowableCut");
    }
    public function clientcompany(){
        return $this->belongsTo(Company::class,"ClientCompany");
    }
    public function concessionairecompany(){
        return $this->belongsTo(Company::class,"ConcessionaireCompany");
    }
    public function transportercompany(){
        return $this->belongsTo(Company::class,"TransporterCompany");
    }
    public function user(){
        return $this->belongsTo(User::class,"User");
    }

}
