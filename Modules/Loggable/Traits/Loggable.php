<?php

namespace Modules\Loggable\Traits;

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
    public function initializeAppendAttributeTrait()
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
        return $this->logTableExists();
        if(!$this->getToken()) return;

        $changes = [];

        foreach ($this->getDirty() as $field => $value) {
            $changes[$field] = $value;
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
            ->orderBy('version', 'desc')
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
}
