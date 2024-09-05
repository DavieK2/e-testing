<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Tasks\ClassTasks;

class GetClassSubjectsFeature extends FeatureContract {

    public function __construct(protected ClassModel $class ){
        $this->tasks = new ClassTasks();
    }
    
    public function handle(BaseTasks|ClassTasks $task, array $args = [])
    {
        try {
            
            return $task->class($this->class)->getClassSubjects()->formatResponse();

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}