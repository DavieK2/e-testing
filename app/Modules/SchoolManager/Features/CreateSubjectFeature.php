<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateSubjectsTasks;

class CreateSubjectFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateSubjectsTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->generateSubjectCode()->addSubjectToDatabase();

            return $task::formatResponse($builder->empty(), options: ['message' => 'Subject successfully created', 'status' => 201 ]);
        
       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}