<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\UpdateAssessmentTask;

class UpdateAssessmentFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new UpdateAssessmentTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder = $task->start($args)->updateAssessment();

            return $task::formatResponse( $builder->only(['assessmentId']) , options: ['message' => 'Assessment Updated Successfully', 'status' => 200 ]);

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}