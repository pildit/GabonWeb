<?php

namespace App\Traits;

use GenTux\Jwt\GetsJwtToken;
use GenTux\Jwt\Exceptions\NoTokenException;

use Illuminate\Database\Eloquent\Model;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Route;
use DateTime;
use Auth;

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
     	
     	$user_id = null;

        // If there is no token, then this is the public /register route ;
    	try {
    		$user_id = $this->jwtPayload('data.id');
    	} catch (NoTokenException $e) {
    	}

        $logEntry = new LogEntry();

        $logEntry->action        = $action;
        $logEntry->logged_at     = new DateTime();
        $logEntry->loggable_id   = $this->getKey();
        $logEntry->loggable_type = get_class($this);
        $logEntry->user_id       = $user_id;

        $logEntry->save();

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
}