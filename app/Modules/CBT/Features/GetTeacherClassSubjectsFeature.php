<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\GetTeacherClassSubjectsTasks;
use App\Modules\SchoolManager\Resources\SubjectListCollection;
use App\Modules\UserManager\Models\UserModel;

class GetTeacherClassSubjectsFeature extends FeatureContract {

    public function __construct( protected UserModel $user){
        $this->tasks = new GetTeacherClassSubjectsTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            $builder = $task->start(['teacher' => $this->user ])->getSubjects();

            return $task::formatResponse( $builder->only(['query'])->all(), formatter: SubjectListCollection::class );

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}