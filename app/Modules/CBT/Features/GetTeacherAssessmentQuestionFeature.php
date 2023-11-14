<?php

namespace App\Modules\CBT\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Resources\QuestionListCollection;
use App\Modules\CBT\Tasks\GetTeacherAssessmentQuestionTasks;

class GetTeacherAssessmentQuestionFeature extends FeatureContract {

    public function __construct( protected QuestionBankModel $question_bank ){
        $this->tasks = new GetTeacherAssessmentQuestionTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
       try {

            $builder = $task->start([ ...$args, 'question_bank' => $this->question_bank ])->getQuestions()->all();

            return $task::formatResponse( $builder, formatter: QuestionListCollection::class );

       } catch (\Throwable $th) {
            
            throw $th;
       }
    }
}