<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\AssessmentTasks;

class CreateQuizFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssessmentTasks();
    }
    
    public function handle(BaseTasks|AssessmentTasks $task, array $args = [])
    {
       try {

            return $task->withParameters($args)
                        ->createQuiz()
                        ->addContributors()
                        ->addQuizTakers()
                        ->only(['assessmentId'])
                        ->formatResponse( options: [
                            'message' => 'Quiz Successfully Created'
                        ]);

       } catch (\Throwable $th) {
            
            throw $th;
       }
    }
}