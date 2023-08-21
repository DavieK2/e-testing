<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Constants\CBTConstants;
use App\Modules\CBT\Tasks\CreateAssessmentTasks;

class CreateAssessmentFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateAssessmentTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder = $task->start($args);

            $builder = match(true){
                ( $args['step'] === CBTConstants::CREATE_ASSESSMENT )    => $builder->storeAssessmentToDatabase(),
                ( $args['step'] === CBTConstants::ADD_CLASSES )          => $builder->addAssessmentClasses(),
                ( $args['step'] === CBTConstants::COMPLETE_ASSESSMENT )  => $builder->addSubjectsToAssessment()
            };

            return $task::formatResponse( $builder->only(['assessmentId', 'isStandalone']) );

        } catch (\Throwable $th) {

            throw $th;
        }
      
    }
}