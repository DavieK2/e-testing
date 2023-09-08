<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\ImportQuestionsTask;

class ImportQuestionsFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new ImportQuestionsTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            if( isset( $args['key'] ) ){

                $builder = $task->start($args)->importQuestions();

                return $task::formatResponse( $builder->only(['errors']), options: ['message' => 'Questions Imported Successfully']);

            }else{

                $builder = $task->start($args)->saveFileToLocalDisk();

                return $task::formatResponse( $builder->only(['key', 'headings']) );
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}