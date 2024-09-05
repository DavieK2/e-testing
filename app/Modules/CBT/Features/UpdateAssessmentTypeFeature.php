<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentTypeModel;
use App\Modules\CBT\Tasks\AssessmentTypeTasks;

class UpdateAssessmentTypeFeature extends FeatureContract {

    public function __construct(protected AssessmentTypeModel $assessment_type){
        $this->tasks = new AssessmentTypeTasks();
    }
    
    public function handle(BaseTasks|AssessmentTypeTasks $task, array $args = [])
    {
        try {
            
            return $task->withParameters($args)
                        ->assessmentType( $this->assessment_type )
                        ->updateAssessmentType()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Assessment Type Updated Successfully', 
                            'status' => 200 
                        ]);

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}