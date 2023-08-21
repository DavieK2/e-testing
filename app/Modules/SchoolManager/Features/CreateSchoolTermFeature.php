<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateTermTasks;

class CreateSchoolTermFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateTermTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            $builder = $task->start($args)->storeToDatabase();

            return $task::formatResponse( $builder->empty(), options: ['message' => 'Term created successfully', 'status' => 201 ]);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}