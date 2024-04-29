<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Resources\GetAssessmentQuestionsFormatter;
use App\Modules\CBT\Tasks\GetAssessmentQuestionsTasks;

class GetAssessmentQuestionsFeature extends FeatureContract {

    public function __construct(protected AssessmentModel $assessment){
        $this->tasks = new GetAssessmentQuestionsTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder =  $task->start([ ...$args, 'assessment' => $this->assessment ] )->getAssessmentQuestions();

            return $task::formatResponse( $builder, formatter: GetAssessmentQuestionsFormatter::class );


        } catch (\Throwable $th) {

            throw $th;
        }
    }
}