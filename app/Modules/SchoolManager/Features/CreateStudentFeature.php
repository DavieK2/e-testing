<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateStudentTasks;

class CreateStudentFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateStudentTasks();
    }
    
    public function handle(BaseTasks|CreateStudentTasks $task, array $args = [])
    {
        try {
            
            return $task->withParameters($args)->createStudent()->empty()->formatResponse(
                options: [
                    'message' => 'Student Added Successfully'
                ]
            );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}