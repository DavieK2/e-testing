<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Tasks\ClassListTasks;

class GetClassSubjectsFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new ClassListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start( [...$args ] )->getClassSubjects();

            return $task::formatResponse( $builder );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}