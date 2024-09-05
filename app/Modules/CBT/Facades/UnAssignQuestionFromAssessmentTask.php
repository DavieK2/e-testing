<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask as TasksUnAssignQuestionFromAssessmentTask;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void unAssignQuestionFromAssessment()
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask only(array $keys)
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask empty()
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask perPage()
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask all()
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask search()
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask filter()
 * @method static \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask
 */

class UnAssignQuestionFromAssessmentTask extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksUnAssignQuestionFromAssessmentTask::class;
    }
}