<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\AssignSubjectToClassTask;

class AssignSubjectToClassFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssignSubjectToClassTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start($args)->assignSubjects();

            return $task::formatResponse( $builder->empty(), options: ['message' => 'Subjects assigned successfully', 'status' => 200 ]);

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}