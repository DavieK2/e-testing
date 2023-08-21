<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Tasks\UpdateQuestionTask;

class UpdateQuestionFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new UpdateQuestionTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            $builder = $task->start([ ...$args, 'assessment' => $this->assessment ])->updateQuestion();

            return $task::formatResponse( $builder->empty(), options:['message' => 'Question updated successfully', 'status' => 201 ] );
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}