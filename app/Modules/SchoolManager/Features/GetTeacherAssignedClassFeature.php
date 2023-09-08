<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Resources\ClassListCollection;
use App\Modules\SchoolManager\Tasks\GetTeacherAssignedClassTasks;
use App\Modules\UserManager\Models\UserModel;

class GetTeacherAssignedClassFeature extends FeatureContract {

    public function __construct(protected UserModel $teacher){
        $this->tasks = new GetTeacherAssignedClassTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            $builder = $task->start([ ...$args, 'teacher' => $this->teacher ])->getClasses()->all();

            return $task::formatResponse( $builder, formatter: ClassListCollection::class );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}