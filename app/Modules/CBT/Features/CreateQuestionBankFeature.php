<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\QuestionBankTasks;

class CreateQuestionBankFeature extends FeatureContract {


    public function __construct(){
        $this->tasks = new QuestionBankTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {

        try {
           
            $builder = $task->start( $args )->createQuestionBank()->only(['questionBankId']);

            return $task::formatResponse( $builder, options:['message' => 'Question Bank Created Successfully', 'status' => 201 ] );

        } catch (\Throwable $th) {

            throw $th;
        }

    }
}