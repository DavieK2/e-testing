<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Support\Facades\DB;

class QuestionBankTasks extends BaseTasks {

    public function getQuestions()
    {
        $questions = DB::table('assessment_questions')
                        ->join('questions', 'questions.id', '=', 'assessment_questions.question_id')
                        ->join('assessments', 'assessments.id', '=', 'questions.assessment_id')
                        ->select('questions.question', 'questions.options', 'questions.correct_answer', 'questions.uuid', 'questions.subject_id', 'questions.question_score', 'assessments.uuid as assessmentId');

        if( isset( $this->item['assessmentId'] ) ){

            $assessmentId = AssessmentModel::firstWhere('uuid', $this->item['assessmentId'])->id;

            $questions = $questions->where( fn($query) => $query->where('assessment_questions.assessment_id', '!=', $assessmentId) );
            
        }

        if( isset( $this->item['subjectId'] ) ){

            $questions = $questions->where( fn($query) => $query->where('questions.subject_id', $this->item['subjectId']) );

        }

        if( isset( $this->item['classId'] ) ){

            $classId = ClassModel::firstWhere( 'class_code', $this->item['classId'] )->id;
            $questions = $questions->where( fn($query) => $query->where('questions.class_id', $classId ) );

        }

        return new static([ ...$this->item, 'query' => $questions ]);
    }
    
}