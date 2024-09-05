<?php

namespace App\Modules\SchoolManager\Facades;


use App\Modules\SchoolManager\Tasks\StudentTasks as TasksStudentTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks getStudents()
 * @method static void downloadStudentData()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks student(\App\Modules\SchoolManager\Models\StudentProfileModel $student)
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks getAssignedSubjects()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks assignSubjectToStudent()
 * @method static void updateProfile()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks withParameters(array $params)
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks only(array $keys)
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks empty()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks perPage()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks all()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks search()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks filter()
 * @method static \App\Modules\SchoolManager\Tasks\StudentTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\SchoolManager\Tasks\StudentTasks
 */

class StudentTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksStudentTasks::class;
    }
}