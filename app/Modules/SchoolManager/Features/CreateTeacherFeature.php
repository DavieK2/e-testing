<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\TeacherTasks;

class CreateTeacherFeature extends FeatureContract {

    public function __construct(){
        
        $this->tasks = new TeacherTasks();
    }
    
    public function handle(BaseTasks|TeacherTasks $task, array $args = [])
    {
        try {
           
            return $task->withParameters($args)
                        ->createTeacher()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Teacher created successfully'
                        ]);

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}