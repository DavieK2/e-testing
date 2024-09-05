<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\AssessmentTypeTasks;

class CreateAssessmentTypeFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssessmentTypeTasks();
    }
    
    public function handle(BaseTasks|AssessmentTypeTasks $task, array $args = [])
    {
        try {
            
            return $task->withParameters($args)
                        ->createAssessmentType()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Assessment Type Created Successfully', 
                            'status' => 201 
                        ]);

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}