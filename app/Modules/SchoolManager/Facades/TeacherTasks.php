<?php

namespace App\Modules\SchoolManager\Facades;


use App\Modules\SchoolManager\Tasks\TeacherTasks as TasksTeacherTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks assignTeacherToClass()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks createTeacher()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks assignTeacherToSubject()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks classes()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks subjects()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks getTeachers()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks teacher(\App\Modules\UserManager\Models\UserModel $teacher)
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks assignClassSubjects()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks withParameters(array $params)
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks only(array $keys)
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks empty()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks perPage()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks all()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks search()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks filter()
 * @method static \App\Modules\SchoolManager\Tasks\TeacherTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\SchoolManager\Tasks\TeacherTasks
 */

class TeacherTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksTeacherTasks::class;
    }
}