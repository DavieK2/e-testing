<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\AssignTeacherToSubjectTask;

class AssignTeacherToSubjectFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssignTeacherToSubjectTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->assignTeacherToSubject();

            return $task::formatResponse( $builder->empty() );

       } catch (\Throwable $th) {
            
            throw $th;
       }
    }
}