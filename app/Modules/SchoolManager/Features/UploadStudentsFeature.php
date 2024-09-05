<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateStudentTasks;

class UploadStudentsFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateStudentTasks();
    }
    
    public function handle(BaseTasks|CreateStudentTasks $task, array $args = [])
    {
        try {
            
            return $task->withParameters($args)
                        ->uploadCSV()
                        ->formatResponse();

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}