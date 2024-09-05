<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\AcademicSessionTasks;

class CreateAcademicSessionFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AcademicSessionTasks();
    }
    
    public function handle(BaseTasks|AcademicSessionTasks $task, array $args = [])
    {
       try {
            
            return $task->withParameters($args)
                        ->createAcademicSession()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Academic Session created successfully'
                        ]);

       } catch (\Throwable $th) {

            throw $th;
       }
    }
}