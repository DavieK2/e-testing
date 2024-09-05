<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\QuestionListTasks as TasksQuestionListTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void getQuestions()
 * @method static void getAssignedQuestions()
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks empty()
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks perPage()
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks all()
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks search()
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks filter()
 * @method static \App\Modules\CBT\Tasks\QuestionListTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\QuestionListTasks
 */

class QuestionListTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksQuestionListTasks::class;
    }
}