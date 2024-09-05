<?php

namespace App\Modules\DatabaseSyncManager\Facades;


use App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks as TasksSyncDatabaseTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void sync()
 * @method static void save(void $path, void $table)
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks withParameters(array $params)
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks only(array $keys)
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks empty()
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks perPage()
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks all()
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks search()
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks filter()
 * @method static \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\DatabaseSyncManager\Tasks\SyncDatabaseTasks
 */

class SyncDatabaseTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksSyncDatabaseTasks::class;
    }
}