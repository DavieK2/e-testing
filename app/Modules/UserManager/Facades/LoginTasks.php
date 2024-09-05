<?php

namespace App\Modules\UserManager\Facades;


use App\Modules\UserManager\Tasks\LoginTasks as TasksLoginTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void checkIfUserExists()
 * @method static void login()
 * @method static \App\Modules\UserManager\Tasks\LoginTasks withParameters(array $params)
 * @method static \App\Modules\UserManager\Tasks\LoginTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\UserManager\Tasks\LoginTasks only(array $keys)
 * @method static \App\Modules\UserManager\Tasks\LoginTasks empty()
 * @method static \App\Modules\UserManager\Tasks\LoginTasks perPage()
 * @method static \App\Modules\UserManager\Tasks\LoginTasks all()
 * @method static \App\Modules\UserManager\Tasks\LoginTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\UserManager\Tasks\LoginTasks search()
 * @method static \App\Modules\UserManager\Tasks\LoginTasks filter()
 * @method static \App\Modules\UserManager\Tasks\LoginTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\UserManager\Tasks\LoginTasks
 */

class LoginTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksLoginTasks::class;
    }
}