<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Resources\QuestionBankCollection;
use App\Modules\CBT\Tasks\QuestionBankTasks;

class QuestionBankFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new QuestionBankTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder = $task->start($args)->getQuestions();
            
            foreach($args as $key => $value){
                $builder = $builder->$key();
            }

            return $task::formatResponse( $builder, formatter: QuestionBankCollection::class );

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}