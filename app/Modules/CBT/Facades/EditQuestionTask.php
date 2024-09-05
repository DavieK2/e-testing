<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\EditQuestionTask as TasksEditQuestionTask;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask only(array $keys)
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask empty()
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask perPage()
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask all()
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask search()
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask filter()
 * @method static \App\Modules\CBT\Tasks\EditQuestionTask sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\EditQuestionTask
 */

class EditQuestionTask extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksEditQuestionTask::class;
    }
}