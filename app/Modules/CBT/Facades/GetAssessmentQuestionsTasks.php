<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks as TasksGetAssessmentQuestionsTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void getAssessmentQuestions()
 * @method static void getCachedQuestions()
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks empty()
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks perPage()
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks all()
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks search()
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks filter()
 * @method static \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks
 */

class GetAssessmentQuestionsTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksGetAssessmentQuestionsTasks::class;
    }
}