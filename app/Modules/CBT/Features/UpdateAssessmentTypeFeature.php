<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\UpdateAssessmentTypeTasks;

class UpdateAssessmentTypeFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new UpdateAssessmentTypeTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start($args)->updateAssessmentType();

            return $task::formatResponse($builder->empty(), options: ['message' => 'Assessment Type Updated Successfully', 'status' => 200 ]);

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}