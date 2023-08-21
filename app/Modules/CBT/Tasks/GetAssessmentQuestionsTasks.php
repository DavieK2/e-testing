<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;

class GetAssessmentQuestionsTasks extends BaseTasks {

    public function getAssessmentQuestions()
    {
        $questions = $this->item->questions()->select('questions.uuid as questionId', 'questions.question as prompt', 'questions.options as choices');

        return new static( ['query' => $questions ]);
    }
    
}