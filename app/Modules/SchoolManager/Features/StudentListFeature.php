<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Resources\StudentListCollection;
use App\Modules\SchoolManager\Tasks\StudentTasks;

class StudentListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new StudentTasks();
    }
    
    public function handle( BaseTasks|StudentTasks $task, array $args = [] )
    {
        try {

            return $task->withParameters($args)
                        ->getStudents()
                        ->all()
                        ->formatResponse( 
                            formatter: StudentListCollection::class,
                            formatterOptions: [ 'more_student_info' => request('fullDetails') ? true : false ]
                        );

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}