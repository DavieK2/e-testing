<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Resources\SubjectListCollection;
use App\Modules\SchoolManager\Tasks\GetTeacherAssignedSubjectTasks;
use App\Modules\UserManager\Models\UserModel;

class GetTeacherAssignedSubjectFeature extends FeatureContract {

    public function __construct(protected UserModel $teacher){
        $this->tasks = new GetTeacherAssignedSubjectTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            $builder = $task->start([ ...$args, 'teacher' => $this->teacher ])->getSubjects()->all();

            return $task::formatResponse( $builder, formatter: SubjectListCollection::class );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}