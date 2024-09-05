<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\AssessmentTypeTasks as TasksAssessmentTypeTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks getTypes()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks createAssessmentType()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks updateAssessmentType()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks assessmentType(\App\Modules\CBT\Models\AssessmentTypeModel $assessment_type)
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks empty()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks perPage()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks all()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks search()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks filter()
 * @method static \App\Modules\CBT\Tasks\AssessmentTypeTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\AssessmentTypeTasks
 */

class AssessmentTypeTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksAssessmentTypeTasks::class;
    }
}