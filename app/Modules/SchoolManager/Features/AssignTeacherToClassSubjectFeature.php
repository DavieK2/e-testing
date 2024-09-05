<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\TeacherTasks;
use App\Modules\UserManager\Models\UserModel;

class AssignTeacherToClassSubjectFeature extends FeatureContract {

    public function __construct(protected UserModel $teacher){
        $this->tasks = new TeacherTasks();
    }
    
    public function handle(BaseTasks|TeacherTasks $task, array $args = [])
    {
        try {
            
            return $task->withParameters($args)
                        ->teacher($this->teacher)
                        ->assignClassSubjects()
                        ->formatResponse( options: [
                            'message' => 'Successfully Assigned'
                        ]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}