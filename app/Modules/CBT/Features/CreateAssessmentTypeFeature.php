<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\CreateAssessmentTypeTasks;

class CreateAssessmentTypeFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateAssessmentTypeTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start($args)->addAssessmentTypeToDatabase();

            return $task::formatResponse($builder->empty(), options: ['message' => 'Assessment Type Created Successfully', 'status' => 201 ]);

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}