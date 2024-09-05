<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask as TasksAssignQuestionToAssessmentTask;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void assignQuestionToAssessment()
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask only(array $keys)
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask empty()
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask perPage()
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask all()
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask search()
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask filter()
 * @method static \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\AssignQuestionToAssessmentTask
 */

class AssignQuestionToAssessmentTask extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksAssignQuestionToAssessmentTask::class;
    }
}