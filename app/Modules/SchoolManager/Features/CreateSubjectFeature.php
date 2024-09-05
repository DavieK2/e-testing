<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\SubjectTasks;

class CreateSubjectFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new SubjectTasks();
    }
    
    public function handle(BaseTasks|SubjectTasks $task, array $args = [])
    {
       try {

            return $task->withParameters($args)
                        ->generateSubjectCode()
                        ->addSubjectToDatabase()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Subject successfully created', 
                            'status' => 201 
                        ]);
        
       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}