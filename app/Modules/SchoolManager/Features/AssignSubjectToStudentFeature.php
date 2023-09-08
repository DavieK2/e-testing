<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\AssignSubjectToStudentTasks;

class AssignSubjectToStudentFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssignSubjectToStudentTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            $builder = $task->start($args)->assignSubjectToStudent();

            return $task::formatResponse( $builder->empty() );

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}