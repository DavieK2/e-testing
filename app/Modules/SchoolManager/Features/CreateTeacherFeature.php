<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateTeacherTasks;

class CreateTeacherFeature extends FeatureContract {

    public function __construct(){
        
        $this->tasks = new CreateTeacherTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
           
            $builder = $task->start($args)->createTeacher();

            return $task::formatResponse( $builder->empty(), options: ['message' => 'Teacher created successfully']);

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}