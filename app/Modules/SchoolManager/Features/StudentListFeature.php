<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Resources\StudentListCollection;
use App\Modules\SchoolManager\Tasks\StudentListTask;

class StudentListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new StudentListTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder = $task->getStudents()->all();

            return $task::formatResponse( $builder, formatter: StudentListCollection::class );

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}