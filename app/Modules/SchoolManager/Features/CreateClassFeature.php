<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\ClassTasks;

class CreateClassFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new ClassTasks();
    }
    
    public function handle(BaseTasks|ClassTasks $task, array $args = [])
    {
       try {

            return $task->withParameters($args)
                        ->generateClassCode()
                        ->addClassToDatabase()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Class successfully created', 
                            'status' => 201 
                        ]);

       } catch (\Throwable $th) {
            throw $th;
       }                            
    }
}