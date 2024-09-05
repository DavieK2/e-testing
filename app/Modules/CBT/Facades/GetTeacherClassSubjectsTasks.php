<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks as TasksGetTeacherClassSubjectsTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void getSubjects()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks empty()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks perPage()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks all()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks search()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks filter()
 * @method static \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks
 */

class GetTeacherClassSubjectsTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksGetTeacherClassSubjectsTasks::class;
    }
}