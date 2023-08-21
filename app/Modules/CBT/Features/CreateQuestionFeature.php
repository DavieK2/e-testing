<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Tasks\CreateQuestionTasks;

class CreateQuestionFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new CreateQuestionTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start([ ...$args, 'assessment' => $this->assessment ])->createQuestion()->only(['questionId']);

            return $task::formatResponse( $builder, options:['message' => 'Question created successfully', 'status' => 201 ] );

       } catch (\Throwable $th) {

            throw $th;
       }
    }
}