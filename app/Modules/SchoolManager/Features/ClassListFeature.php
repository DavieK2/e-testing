<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\ClassTasks;

class ClassListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new ClassTasks();
    }
    
    public function handle(BaseTasks|ClassTasks $task, array $args = [])
    {
       try {

            return $task->getClasses()->all()->formatResponse();

       } catch (\Throwable $th) {

            throw $th;
       }
    }
}