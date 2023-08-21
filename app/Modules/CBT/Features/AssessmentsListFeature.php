<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Resources\AssessmentListCollection;
use App\Modules\CBT\Tasks\AssessmentListTasks;

class AssessmentsListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssessmentListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {

        $builder = $task->start($args)->getAssessments();

        foreach($args as $key => $value){

            $builder = $builder->$key();
        }

        return $task::formatResponse($builder, formatter: AssessmentListCollection::class);
    }
}