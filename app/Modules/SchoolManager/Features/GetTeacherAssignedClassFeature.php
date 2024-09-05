<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Resources\ClassListCollection;
use App\Modules\SchoolManager\Tasks\TeacherTasks;
use App\Modules\UserManager\Models\UserModel;

class GetTeacherAssignedClassFeature extends FeatureContract {

    public function __construct(protected UserModel $teacher){
        $this->tasks = new TeacherTasks();
    }
    
    public function handle(BaseTasks|TeacherTasks $task, array $args = [])
    {
        try {
            return $task->teacher($this->teacher)
                        ->classes()
                        ->all()
                        ->formatResponse( formatter: ClassListCollection::class );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}