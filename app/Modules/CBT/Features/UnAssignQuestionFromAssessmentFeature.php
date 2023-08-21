<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Tasks\UnAssignQuestionFromAssessmentTask;

class UnAssignQuestionFromAssessmentFeature extends FeatureContract {

    public function __construct( protected AssessmentModel $assessment){
        $this->tasks = new UnAssignQuestionFromAssessmentTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start([ ...$args, 'assessment' => $this->assessment ])->unAssignQuestionFromAssessment();

            return $task::formatResponse( $builder->empty(), options:['message' => 'Question successfully assigned to assessment', 'status' => 200 ] );

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}