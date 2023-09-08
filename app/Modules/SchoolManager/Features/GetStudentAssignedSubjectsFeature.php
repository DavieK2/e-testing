<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Resources\GetStudentAssignedSubjectsCollection;
use App\Modules\SchoolManager\Tasks\GetStudentAssignedSubjectsTasks;

class GetStudentAssignedSubjectsFeature extends FeatureContract {

    public function __construct(protected StudentProfileModel $student){
        $this->tasks  = new GetStudentAssignedSubjectsTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start($this->student)->getAssignedSubjects()->all();

            return $task::formatResponse( $builder, formatter: GetStudentAssignedSubjectsCollection::class );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}