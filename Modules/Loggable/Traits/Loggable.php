<?php

namespace Modules\Loggable\Traits;

use Brick\Geo\IO\EWKBReader;
use GenTux\Jwt\GetsJwtToken;
use GenTux\Jwt\Exceptions\NoTokenException;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Loggable\Entities\LogEntry;

use Illuminate\Support\Facades\Route;
use DateTime;

trait Loggable
{

	use GetsJwtToken;

    /**
     * @var string
     */
    private static $actionCreate = 0;

    /**
     * @var string
     */
    private static $actionUpdate = 1;

    /**
     * @var string
     */
    private static $actionRemove = 2;

    /**
     *  Append log attribute
     */
    public function initializeLoggable()
    {
        $this->append('log');
    }

    /**
     * Boot the loggable trait for a model.
     *
     * @return void
     */
    public static function bootLoggable()
    {
        static::created(function (Model $model) {
            $model->createLogEntry(self::$actionCreate);
        });

        static::updated(function (Model $model) {
            $model->createLogEntry(self::$actionUpdate);
        });

        static::deleted(function (Model $model) {
            $model->createLogEntry(self::$actionRemove);
        });
    }

    /**
     * Create a new Log Entry
     *
     * @param int $action
     */
    public function createLogEntry($action)
    {
        if(!$this->logTableExists()) return;
        if(!$this->getToken()) return;

//        $changes = [];
//        foreach ($this->getDirty() as $field => $value) {
//            $changes[$field] = $value;
//            if($field == 'Geometry') {
//                dd();
//            }
//        }

        $changes = $this->getChanges();
        $original = $this->getOriginal();
        if(isset($changes['Geometry'])) {
            $changes['geometry_as_text'] = $this->geometryAsText($changes['Geometry']);
            unset($changes['Geometry']);
        }
        if(isset($original['Geometry'])) {
            $original['geometry_as_text'] = $this->geometryAsText($original['Geometry']);
            unset($original['Geometry']);
        }
        // If there is no token, then this is the public /register route ;
//		$user_id = $this->getToken() ? $this->jwtPayload('data.id') : null;
        $logEntry = new LogEntry();

        $logEntry->action        = $action;
        $logEntry->logged_at     = new DateTime();
        $logEntry->loggable_id   = $this->getKey();
        $logEntry->loggable_type = get_class($this);
        $logEntry->user_id       = $this->jwtPayload('data.id');
        $logEntry->version       = $this->getNewVersionNumber();
        $logEntry->data          = json_encode($changes);
        $logEntry->original_data = json_encode($original);

        $logEntry->save();

    }

    /**
     * Get the next vesion number
     *
     * @return int
     */
    protected function getNewVersionNumber()
    {
        $newVersion = DB::table('public.log_entries')
            ->where('loggable_id', '=', $this->getKey())
            ->where('loggable_type', '=', get_class($this))
            ->max('version');

        return $newVersion + 1;
    }

    public function getLogAttribute()
    {
        if(!$this->logTableExists()) return null;
        return DB::table('public.log_entries')
            ->where('loggable_id', '=', $this->getKey())
            ->where('loggable_type', '=', get_class($this))
            ->where('action', '=', self::$actionUpdate)
            ->orderBy('version', 'desc')
//            ->skip(1) // take the previous change.
            ->first();
    }

    /**
     * Get all entries
     *
     * @return MorphMany
     */
    public function logEntries()
    {
        return $this->morphMany(LogEntry::class, 'loggable');
    }

    /**
     * @return bool
     */
    protected function logTableExists(): bool
    {
        try {
            DB::table('public.log_entries')->get();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function geometryAsText($value)
    {
        if(ctype_xdigit($value)) {
            $reader = new EWKBReader();
            $geom = $reader->read(hex2bin($value));
            return $geom->asText();
        }else{
            return $value;
        }
    }
}
