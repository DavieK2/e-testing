<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Support\Facades\DB;

class GetAssessmentQuestionsTasks extends BaseTasks {

    public function getAssessmentQuestions()
    {
        if( $this->item['assessment']->is_standalone ){
            
            $questions = $this->item['assessment']->questions()->select('questions.uuid as questionId', 'questions.question as prompt', 'questions.options as choices');

        }else{
            
            $subjectId = SubjectModel::firstWhere('subject_code', $this->item['subjectId'])->uuid;

            $questions = DB::table('assessment_questions')
                            ->inRandomOrder()
                            ->join('questions', 'questions.uuid', '=', 'assessment_questions.question_id')
                            ->leftJoin('sections', 'sections.uuid', '=', 'assessment_questions.section_id')
                            ->where( fn($query) => $query->where( 'assessment_questions.subject_id', $subjectId )->where( 'assessment_questions.class_id', $this->item['user']->class_id )->where( 'assessment_questions.assessment_id', $this->item['assessment']->uuid ) )
                            ->select('questions.uuid as questionId', 'questions.question as prompt', 'questions.options as choices', 'assessment_questions.section_id', 'sections.title');

        }


        $questions = $questions->get();

        return new static(  $questions );
    }
    
}