<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\UpdateAcademicSessionTasks;

class UpdateAcademicSessionFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new UpdateAcademicSessionTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {
            
            $builder = $task->start($args)->updateAcademicSession();

            return $task::formatResponse( $builder->empty(), options:['status' => 200, 'message' => 'Academic updated successfuly'] );

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}