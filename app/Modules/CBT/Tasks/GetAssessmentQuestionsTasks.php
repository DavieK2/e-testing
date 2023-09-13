<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\SubjectModel;

class GetAssessmentQuestionsTasks extends BaseTasks {

    public function getAssessmentQuestions()
    {
        if( $this->item['assessment']->is_standalone ){
            
            $questions = $this->item['assessment']->questions()->select('questions.uuid as questionId', 'questions.question as prompt', 'questions.options as choices');

        }else{
            
            $subjectId = SubjectModel::firstWhere('subject_code', $this->item['subjectId'])->id;

            $questions = $this->item['assessment']->questions()
                                                ->where( fn($query) => $query->where('assessment_questions.subject_id', $subjectId)
                                                ->where('assessment_questions.class_id', $this->item['user']->class_id ))
                                                ->select('questions.uuid as questionId', 'questions.question as prompt', 'questions.options as choices');

        }

        return new static( ['query' => $questions ]);
    }
    
}