<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Resources\GetAssessmentSubjectsCollection;
use App\Modules\CBT\Tasks\GetAssessmentSubjectsTasks;

class GetAssessmentSubjectsFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new GetAssessmentSubjectsTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {
            
            return $task->start([ 'assessment' => $this->assessment, ...$args ])->getSubjects()->formatResponse();

        } catch (\Throwable $th) {

            throw $th;
        }
    }
}