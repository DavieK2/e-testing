<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Tasks\StudentTasks;

class UpdateStudentFeature extends FeatureContract {

    public function __construct( protected StudentProfileModel $student ){
        $this->tasks = new StudentTasks();
    }
    
    public function handle(BaseTasks|StudentTasks $task, array $args = [])
    {
        try {

            return $task->withParameters($args)
                        ->student( $this->student )
                        ->updateProfile()
                        ->empty()
                        ->formatResponse( options: [
                            'message' => 'Student Profile Successfully Updated'
                        ]);

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}