<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateStudentTasks;

class UploadStudentsFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateStudentTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start($args)->uploadCSV();

            return $task::formatResponse( $builder );

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}