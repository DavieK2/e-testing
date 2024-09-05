<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Resources\AssessmentListCollection;
use App\Modules\CBT\Tasks\AssessmentTasks;

class AssessmentsListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssessmentTasks();
    }
    
    public function handle(BaseTasks|AssessmentTasks $task, array $args = [])
    {

        return $task->getAssessments()
                    ->all()
                    ->formatResponse( 
                        formatter: AssessmentListCollection::class 
                    );
    }
}