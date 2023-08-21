<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\AssessmentTypeListTasks;

class AssessmentTypeListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssessmentTypeListTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder = $task->start($args)->getTypes()->all();

            return $task::formatResponse($builder);

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}