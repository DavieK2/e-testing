<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use Illuminate\Support\Facades\DB;

class QuestionBankTasks extends BaseTasks{

    public function getQuestions()
    {
        $questions = DB::table('assessment_questions')->join('questions', 'questions.id', '=', 'assessment_questions.question_id');

        return new static([ ...$this->item, 'query' => $questions ]);
    }
    
}