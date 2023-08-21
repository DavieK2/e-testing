<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\UpdateTermTasks;

class UpdateTermFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new UpdateTermTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {
            
            $builder = $task->start($args)->updateTerm();

            return $task::formatResponse( $builder->empty(), options:['status' => 200, 'message' => 'Term updated successfuly'] );

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}