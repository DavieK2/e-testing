<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Resources\QuizResource;
use App\Modules\CBT\Tasks\AssessmentTasks;

class EditQuizFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new AssessmentTasks();
    }
    
    public function handle(BaseTasks|AssessmentTasks $task, array $args = [])
    {
        return $task->setItem($this->assessment)
                    ->formatResponse( formatter: QuizResource::class );
    }
}