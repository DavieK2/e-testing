<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Tasks\CreateStudentTasks;

class ImportStudentDataFromFileFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new CreateStudentTasks();
    }
    
    public function handle(BaseTasks|CreateStudentTasks $task, array $args = [])
    {
        return $task->withParameters($args)
                    ->importStudentData()
                    ->empty()
                    ->formatResponse( 
                        options: [
                            'message' => 'Data Imported Successfully'
                    ]);
    }
}