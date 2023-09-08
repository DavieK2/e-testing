<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\AssignTeacherToClassTask;

class AssignTeacherToClassFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssignTeacherToClassTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start($args)->assignTeacherToClass();

            return $task::formatResponse( $builder->empty() );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}