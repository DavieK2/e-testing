<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Resources\QuestionListCollection;
use App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks;

class GetTeacherAssessmentQuestionFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new GetTeacherAssessmentQuestionTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start($args)->getQuestions()->all();

            return $task::formatResponse( $builder, formatter: QuestionListCollection::class );

       } catch (\Throwable $th) {
            
            throw $th;
       }
    }
}