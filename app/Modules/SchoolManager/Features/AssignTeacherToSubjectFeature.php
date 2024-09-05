<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\TeacherTasks;
use App\Modules\UserManager\Models\UserModel;

class AssignTeacherToSubjectFeature extends FeatureContract {

    public function __construct( protected UserModel $teacher ){
        $this->tasks = new TeacherTasks();
    }
    
    public function handle(BaseTasks|TeacherTasks $task, array $args = [])
    {
       try {

            return $task->withParameters($args)
                        ->teacher($this->teacher)
                        ->assignTeacherToSubject()
                        ->empty()
                        ->formatResponse();

       } catch (\Throwable $th) {
            
            throw $th;
       }
    }
}