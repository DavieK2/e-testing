<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateClassTasks;

class CreateClassFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateClassTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->generateClassCode()->addClassToDatabase();

            return $task::formatResponse($builder->empty(), options: ['message' => 'Class successfully created', 'status' => 201 ]);

       } catch (\Throwable $th) {
            throw $th;
       }                            
    }
}