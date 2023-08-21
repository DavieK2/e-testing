<?php

namespace App\Modules\SchoolManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\SchoolManager\Models\SubjectModel;
use App\Modules\SchoolManager\Tasks\SubjectListTasks;

class SubjectListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new SubjectListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder = $task->start($args)->getSubjects()->all();

            return $task::formatResponse($builder);

       } catch (\Throwable $th) {
        
            throw $th;
       }
    }
}