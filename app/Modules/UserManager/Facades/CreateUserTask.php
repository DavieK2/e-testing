<?php

namespace App\Modules\UserManager\Facades;


use App\Modules\UserManager\Tasks\CreateUserTask as TasksCreateUserTask;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void createUser()
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask withParameters(array $params)
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask except(array $keys, bool $recursive = false)
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask only(array $keys)
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask empty()
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask perPage()
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask all()
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask search()
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask filter()
 * @method static \App\Modules\UserManager\Tasks\CreateUserTask sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\UserManager\Tasks\CreateUserTask
 */

class CreateUserTask extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksCreateUserTask::class;
    }
}