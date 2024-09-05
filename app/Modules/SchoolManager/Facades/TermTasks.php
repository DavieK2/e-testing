<?php

namespace App\Modules\SchoolManager\Facades;


use App\Modules\SchoolManager\Tasks\TermTasks as TasksTermTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void getTerms()
 * @method static void updateTerm()
 * @method static void term(\App\Modules\SchoolManager\Models\TermModel $term)
 * @method static void createTerm()
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks withParameters(array $params)
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks only(array $keys)
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks empty()
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks perPage()
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks all()
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks search()
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks filter()
 * @method static \App\Modules\SchoolManager\Tasks\TermTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\SchoolManager\Tasks\TermTasks
 */

class TermTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksTermTasks::class;
    }
}