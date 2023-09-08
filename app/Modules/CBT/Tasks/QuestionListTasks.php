<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;
use Illuminate\Support\Facades\DB;

class QuestionListTasks extends BaseTasks{

    public function getQuestions()
    {
        $questions = QuestionModel::where( 'questions.assessment_id', $this->item['assessment']->id )->leftJoin('assessment_questions', 'questions.id', '=', 'assessment_questions.question_id')->select('questions.*', 'assessment_questions.assessment_id as assessmentId');

        $questions = $questions->fromSub($questions, 'questions')->whereNull('questions.assessmentId')->orderBy('questions.updated_at');

        return new static( [ ...$this->item, 'query' => $questions ] );
    }

    public function getAssignedQuestions()
    {
        $questions = DB::table('assessment_questions')
                        ->where('assessment_questions.assessment_id', $this->item['assessment']->id)
                        ->join('questions', 'questions.id', '=', 'assessment_questions.question_id')
                        ->join('assessments', 'assessments.id', '=', 'assessment_questions.assessment_id')
                        ->select('questions.*', 'assessments.uuid as assessmentId');

        return new static( [ ...$this->item, 'query' => $questions ] );
    }
    
}