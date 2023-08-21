<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateAcademicSessionTasks;

class CreateAcademicSessionFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateAcademicSessionTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {
            
            $builder = $task->start($args)->storeToDatabase();

            return $task::formatResponse( $builder->empty(), options: ['message' => 'Academic Session created successfully']);

       } catch (\Throwable $th) {

            throw $th;
       }
    }
}