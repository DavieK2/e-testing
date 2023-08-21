<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Resources\GetAssessmentResource;

class GetAssessmentFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new class extends BaseTasks {};
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start( $this->assessment );

            return $task::formatResponse( $builder , formatter: GetAssessmentResource::class );

       } catch (\Throwable $th) {
            
            throw $th;
       }
    }
}