<?php

namespace App\Modules\SchoolManager\Facades;


use App\Modules\SchoolManager\Tasks\SubjectTasks as TasksSubjectTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void generateSubjectCode()
 * @method static void addSubjectToDatabase()
 * @method static void getSubjects()
 * @method static void subject(\App\Modules\SchoolManager\Models\SubjectModel $subject)
 * @method static void updateSubject()
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks withParameters(array $params)
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks only(array $keys)
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks empty()
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks perPage()
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks all()
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks search()
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks filter()
 * @method static \App\Modules\SchoolManager\Tasks\SubjectTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\SchoolManager\Tasks\SubjectTasks
 */

class SubjectTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksSubjectTasks::class;
    }
}