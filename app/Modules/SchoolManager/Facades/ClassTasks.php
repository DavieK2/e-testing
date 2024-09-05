<?php

namespace App\Modules\SchoolManager\Facades;


use App\Modules\SchoolManager\Tasks\ClassTasks as TasksClassTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void generateClassCode()
 * @method static void addClassToDatabase()
 * @method static void getClasses()
 * @method static void class(\App\Modules\SchoolManager\Models\ClassModel $class)
 * @method static void getClassSubjects()
 * @method static void updateClass()
 * @method static void assignSubjects()
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks withParameters(array $params)
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks only(array $keys)
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks empty()
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks perPage()
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks all()
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks search()
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks filter()
 * @method static \App\Modules\SchoolManager\Tasks\ClassTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\SchoolManager\Tasks\ClassTasks
 */

class ClassTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksClassTasks::class;
    }
}