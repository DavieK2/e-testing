<?php

namespace App\Modules\CBT\Facades;


use App\Modules\CBT\Tasks\AssessmentTasks as TasksAssessmentTasks;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks storeAssessmentToDatabase()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks addAssessmentClasses()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks addSubjectsToAssessment()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks assessment(\App\Modules\CBT\Models\AssessmentModel $assessment)
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks createQuiz()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks addContributors()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks addQuizTakers()
 * @method static void getQuizContributors()
 * @method static \App\Contracts\BaseTasks getAssessments()
 * @method static \App\Contracts\BaseTasks getAssignedAssesments()
 * @method static void getAssessmentClasses()
 * @method static void getSubjects()
 * @method static void getPublishedAssessments()
 * @method static void updateAssessment()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks withParameters(array $params)
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks except(array $keys, bool $recursive = false)
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks only(array $keys)
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks empty()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks perPage()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks all()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks asArray()
 * @method static void getItems()
 * @method static void setItem(void $value)
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks search()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks filter()
 * @method static \App\Modules\CBT\Tasks\AssessmentTasks sort()
 * @method static void formatResponse(\App\Contracts\ResponseType $responseType = unknown, array $options = [], string $formatter = '')
 *
 * @see \App\Modules\CBT\Tasks\AssessmentTasks
 */

class AssessmentTasks extends Facade{

    protected static function getFacadeAccessor()
    {
        return TasksAssessmentTasks::class;
    }
}