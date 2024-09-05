<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\CreateQuestionTasks as TasksCreateQuestionTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void createQuestion()
 * @method static void formatQuestionJSON(array $questionData)
 * @method static void formatQuestionOptions(array $questionOptions, void $correctAnswer)
 * @method static void getImageContent(void $content)
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks empty()
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks perPage()
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks all()
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks search()
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks filter()
 * @method static \App\Modules\CBT\Tasks\CreateQuestionTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\CreateQuestionTasks
 */

class CreateQuestionTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksCreateQuestionTasks::class;
    }
}