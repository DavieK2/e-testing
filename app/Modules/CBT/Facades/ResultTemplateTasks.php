<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\ResultTemplateTasks as TasksResultTemplateTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks empty()
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks perPage()
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks all()
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks search()
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks filter()
 * @method static \App\Modules\CBT\Tasks\ResultTemplateTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\ResultTemplateTasks
 */

class ResultTemplateTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksResultTemplateTasks::class;
    }
}