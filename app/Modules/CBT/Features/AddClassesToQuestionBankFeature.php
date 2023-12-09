<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\QuestionBankTasks;

class AddClassesToQuestionBankFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new QuestionBankTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       
        try {
           
            $builder = $task->start( $args )->addClassesToQuestionBank();

            return $task::formatResponse( $builder, options:['message' => 'Classes Added To Question Bank Successfully', 'status' => 200 ] );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}