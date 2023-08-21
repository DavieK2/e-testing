<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\AcademicSessionListTasks;

class AcademicSessionListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AcademicSessionListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->getSessions()->all();

            return $task::formatResponse($builder);
            
       } catch (\Throwable $th) {

            throw $th;
       }
    }
}