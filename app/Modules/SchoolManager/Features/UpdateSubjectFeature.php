<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\UpdateSubjectTasks;

class UpdateSubjectFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new UpdateSubjectTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->updateSubject();

            return $task::formatResponse( $builder->empty(), options: [ 'message' => 'Subject update successfully', 'status' => 200 ]);

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}