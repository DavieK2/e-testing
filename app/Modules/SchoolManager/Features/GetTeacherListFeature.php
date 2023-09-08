<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Resources\GetTeachersListCollection;
use App\Modules\SchoolManager\Tasks\GetTeacherListTasks;

class GetTeacherListFeature extends FeatureContract {

    public function __construct(){

        $this->tasks = new GetTeacherListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {
        
            $builder = $task->start($args)->getTeachers()->all();

            return $task::formatResponse( $builder, formatter: GetTeachersListCollection::class );

       } catch (\Throwable $th) {

            throw $th;
       }
    }
}