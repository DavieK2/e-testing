<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\GetTeacherClassesTask as TasksGetTeacherClassesTask;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void getClasses()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask only(array $keys)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask empty()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask perPage()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask all()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask search()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask filter()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassesTask sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\GetTeacherClassesTask
 */

class GetTeacherClassesTask extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksGetTeacherClassesTask::class;
    }
}