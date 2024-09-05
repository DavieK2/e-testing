<?php

namespace App\Modules\SchoolManager\Facades;


use App\Modules\SchoolManager\Tasks\AcademicSessionTasks as TasksAcademicSessionTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void getSessions()
 * @method static void createAcademicSession()
 * @method static void updateAcademicSession()
 * @method static void academicSession(\App\Modules\SchoolManager\Models\AcademicSessionModel $academic_session)
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks withParameters(array $params)
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks only(array $keys)
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks empty()
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks perPage()
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks all()
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks search()
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks filter()
 * @method static \App\Modules\SchoolManager\Tasks\AcademicSessionTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\SchoolManager\Tasks\AcademicSessionTasks
 */

class AcademicSessionTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksAcademicSessionTasks::class;
    }
}