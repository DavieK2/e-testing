<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Resources\GetStudentAssignedSubjectsCollection;
use App\Modules\SchoolManager\Tasks\StudentTasks;

class GetStudentAssignedSubjectsFeature extends FeatureContract {

    public function __construct(protected StudentProfileModel $student){
        $this->tasks  = new StudentTasks();
    }
    
    public function handle(BaseTasks|StudentTasks $task, array $args = [])
    {
        try {
            
            return $task->student( $this->student )
                        ->getAssignedSubjects()
                        ->all()
                        ->formatResponse( formatter: GetStudentAssignedSubjectsCollection::class );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}