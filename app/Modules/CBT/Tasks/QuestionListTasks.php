<?php

namespace App\Modules\CBT\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Support\Facades\DB;

class QuestionListTasks extends BaseTasks{

    public function getQuestions()
    {
        if( isset( $this->item['questionBankId'] ) ){

            $question_bank = QuestionBankModel::firstWhere( 'uuid', $this->item['questionBankId'] );
            $questions = QuestionModel::where( 'questions.question_bank_id', $question_bank->id )
                                        ->leftJoin('assessment_questions', 'questions.id', '=', 'assessment_questions.question_id')
                                        ->select('questions.*', 'assessment_questions.assessment_id as assessmentId');
        }

        if( isset( $this->item['assessmentId'] ) && ! isset( $this->item['questionBankId'] )){

            $assessment = AssessmentModel::firstWhere('uuid', $this->item['assessmentId'] );
            $questions = QuestionModel::where( 'questions.assessment_id', $assessment->id )
                                        ->leftJoin('assessment_questions', 'questions.id', '=', 'assessment_questions.question_id')
                                        ->select('questions.*', 'assessment_questions.assessment_id as assessmentId');
        }
        
        if( isset( $questions ) ){

            $questions = $questions->fromSub($questions, 'questions')
                                    ->leftJoin('topics', 'topics.id', '=', 'questions.topic_id')
                                    ->leftJoin('sections', 'sections.id', '=', 'questions.section_id')
                                    ->select('questions.*', 'sections.uuid as sectionId', 'sections.title as sectionTitle', 'topics.uuid as topicId')
                                    ->whereNull('questions.assessmentId')
                                    ->orderBy('questions.created_at');
        }

        return new static( [ ...$this->item, 'query' => $questions ?? [] ] );
    }

    public function getAssignedQuestions()
    {
        if( isset( $this->item['questionBankId'] ) ) {

            $question_bank = QuestionBankModel::firstWhere( 'uuid', $this->item['questionBankId'] );

            $questions = DB::table('assessment_questions')
                            ->join('questions', 'questions.id', '=', 'assessment_questions.question_id')
                            ->leftJoin('topics', 'topics.id', '=', 'questions.topic_id')
                            ->leftJoin('sections', 'sections.id', '=', 'questions.section_id')
                            ->where('questions.question_bank_id', $question_bank->id)
                            ->orderBy('questions.created_at')
                            ->select('questions.*', 'sections.uuid as sectionId', 'sections.title as sectionTitle', 'topics.uuid as topicId');

        }

        if( isset( $this->item['assessmentId'] ) && ! isset( $this->item['questionBankId'] )){

            $assessment = AssessmentModel::firstWhere('uuid', $this->item['assessmentId'] );

            $questions = DB::table('assessment_questions')
                            ->join('questions', 'questions.id', '=', 'assessment_questions.question_id')
                            ->join('topics', 'topics.id', '=', 'questions.topic_id')
                            ->join('sections', 'sections.id', '=', 'questions.section_id')
                            ->where('questions.question_bank_id', $assessment->id)
                            ->orderBy('questions.created_at')
                            ->select('questions.*', 'sections.uuid as sectionId', 'topics.uuid as topicId');

        }

        return new static( [ ...$this->item, 'query' => $questions ?? [] ] );
    }
    
}