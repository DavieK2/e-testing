<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Tasks\AssessmentTasks;

class UpdateQuizFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new AssessmentTasks();
    }
    
    public function handle(BaseTasks|AssessmentTasks $task, array $args = [])
    {
        try {
            
            return $task->withParameters($args)
                        ->assessment( $this->assessment )
                        ->updateQuiz()
                        ->addContributors()
                        ->addQuizTakers()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Quiz Successfully Updated'
                        ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}