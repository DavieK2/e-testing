<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\SubjectTasks;

class SubjectListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new SubjectTasks();
    }
    
    public function handle(BaseTasks|SubjectTasks $task, array $args = [])
    {
        try {

            return $task->withParameters($args)
                        ->getSubjects()
                        ->all()
                        ->formatResponse();

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}