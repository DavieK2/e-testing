<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks as TasksGetTeacherAssessmentQuestionTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void getQuestions()
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks empty()
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks perPage()
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks all()
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks search()
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks filter()
 * @method static \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks
 */

class GetTeacherAssessmentQuestionTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksGetTeacherAssessmentQuestionTasks::class;
    }
}