<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Resources\AssessmentListCollection;
use App\Modules\CBT\Tasks\GetPublishedAssessmentTask;

class GetPublishedAssessmentFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new GetPublishedAssessmentTask();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->getAssessments()->all();

            return $task::formatResponse( $builder );

       } catch (\Throwable $th) {

            throw $th;
       }
    }
}