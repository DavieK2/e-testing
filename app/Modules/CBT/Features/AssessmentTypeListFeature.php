<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Tasks\AssessmentTypeTasks;

class AssessmentTypeListFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new AssessmentTypeTasks();
    }
    
    public function handle( BaseTasks|AssessmentTypeTasks $task, array $args = [] )
    {
        try {

            return $task->getTypes()
                        ->all()
                        ->formatResponse();

        } catch (\Throwable $th) {
            
            throw $th;
        }
    }
}