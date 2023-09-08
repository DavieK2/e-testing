<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\GetTeacherAssignedClassTasks;

class GetTeacherClassesFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new GetTeacherAssignedClassTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            return $task::formatResponse( $task->start($args)->getClasses()->all() );

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}