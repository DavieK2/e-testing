<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\UpdateQuestionTask as TasksUpdateQuestionTask;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void updateQuestion()
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask only(array $keys)
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask empty()
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask perPage()
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask all()
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask search()
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask filter()
 * @method static \App\Modules\CBT\Tasks\UpdateQuestionTask sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\UpdateQuestionTask
 */

class UpdateQuestionTask extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksUpdateQuestionTask::class;
    }
}