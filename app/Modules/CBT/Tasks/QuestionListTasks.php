<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Support\Facades\DB;

class QuestionListTasks extends BaseTasks{

    public function getQuestions()
    {
        $questions = QuestionModel::where( 'questions.assessment_id', $this->item['assessment']->id )->leftJoin('assessment_questions', 'questions.id', '=', 'assessment_questions.question_id')->select('questions.*', 'assessment_questions.assessment_id as assessmentId');

        $questions = $questions->fromSub($questions, 'questions')->whereNull('questions.assessmentId')->orderBy('questions.updated_at');

        if( isset($this->item['subjectId']) && $this->item['subjectId'] ){

            $classId = ClassModel::firstWhere('class_code', $this->item['classId'] )->id;

            $questions->where( fn($query) => $query->where('questions.subject_id', $this->item['subjectId'])->where('questions.class_id', $classId) );
        }

        return new static( [ ...$this->item, 'query' => $questions ] );
    }

    public function getAssignedQuestions()
    {
        $questions = DB::table('assessment_questions')
                        ->where('assessment_questions.assessment_id', $this->item['assessment']->id)
                        ->join('questions', 'questions.id', '=', 'assessment_questions.question_id')
                        ->join('assessments', 'assessments.id', '=', 'assessment_questions.assessment_id')
                        ->select('questions.*', 'assessments.uuid as assessmentId');

        if( isset($this->item['subjectId']) && $this->item['subjectId'] ){

            $classId = ClassModel::firstWhere('class_code', $this->item['classId'] )->id;

            $questions->where( fn($query) => $query->where('assessment_questions.subject_id', $this->item['subjectId'])->where('assessment_questions.class_id', $classId) );
        }

        return new static( [ ...$this->item, 'query' => $questions ] );
    }
    
}