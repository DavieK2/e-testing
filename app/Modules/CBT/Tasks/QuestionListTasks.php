<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;
use Illuminate\Support\Facades\DB;

class QuestionListTasks extends BaseTasks{

    public function getQuestions()
    {
        $questions = QuestionModel::where( 'assessment_id', $this->item['assessment']->id );

        return new static( [ ...$this->item, 'query' => $questions ] );
    }

    public function getAssignedQuestions()
    {
        $questions = DB::table('assessment_questions')
                        ->where('assessment_questions.assessment_id', $this->item['assessment']->id)
                        ->join('questions', 'questions.id', '=', 'assessment_questions.question_id');

        return new static( [ ...$this->item, 'query' => $questions ] );
    }
    
}