<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Resources\GetTeachersListCollection;
use App\Modules\SchoolManager\Tasks\TeacherTasks;

class GetTeacherListFeature extends FeatureContract {

    public function __construct(){

        $this->tasks = new TeacherTasks();
    }
    
    public function handle(BaseTasks|TeacherTasks $task, array $args = [])
    {
       try {
        
            return $task->getTeachers()
                        ->all()
                        ->formatResponse( formatter: GetTeachersListCollection::class );

       } catch (\Throwable $th) {

            throw $th;
       }
    }
}