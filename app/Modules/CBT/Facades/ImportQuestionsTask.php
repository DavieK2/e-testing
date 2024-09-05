<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\ImportQuestionsTask as TasksImportQuestionsTask;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void saveFileToLocalDisk()
 * @method static void importQuestions()
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask only(array $keys)
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask empty()
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask perPage()
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask all()
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask search()
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask filter()
 * @method static \App\Modules\CBT\Tasks\ImportQuestionsTask sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\ImportQuestionsTask
 */

class ImportQuestionsTask extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksImportQuestionsTask::class;
    }
}