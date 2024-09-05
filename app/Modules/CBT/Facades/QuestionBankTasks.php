<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\QuestionBankTasks as TasksQuestionBankTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void createQuestionBank()
 * @method static void addClassesToQuestionBank()
 * @method static void getQuestions()
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks empty()
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks perPage()
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks all()
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks search()
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks filter()
 * @method static \App\Modules\CBT\Tasks\QuestionBankTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\QuestionBankTasks
 */

class QuestionBankTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksQuestionBankTasks::class;
    }
}