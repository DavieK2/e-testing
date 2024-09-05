<?php

namespace App\Modules\SchoolManager\Facades;


use App\Modules\SchoolManager\Tasks\CreateStudentTasks as TasksCreateStudentTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void createStudent()
 * @method static void uploadCSV()
 * @method static void importStudentData()
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks withParameters(array $params)
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks only(array $keys)
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks empty()
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks perPage()
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks all()
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks search()
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks filter()
 * @method static \App\Modules\SchoolManager\Tasks\CreateStudentTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\SchoolManager\Tasks\CreateStudentTasks
 */

class CreateStudentTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksCreateStudentTasks::class;
    }
}