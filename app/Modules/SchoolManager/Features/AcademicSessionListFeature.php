<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\AcademicSessionTasks;

class AcademicSessionListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AcademicSessionTasks();
    }
    
    public function handle(BaseTasks|AcademicSessionTasks $task, array $args = [])
    {
       try {

            return $task->getSessions()
                        ->all()
                        ->formatResponse();
            
       } catch (\Throwable $th) {

            throw $th;
       }
    }
}