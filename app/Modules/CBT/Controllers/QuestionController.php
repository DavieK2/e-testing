<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\AssignQuestionToAssessmentFeature;
use App\Modules\CBT\Features\CreateQuestionFeature;
use App\Modules\CBT\Features\ImportQuestionsFeature;
use App\Modules\CBT\Features\QuestionBankFeature;
use App\Modules\CBT\Features\QuestionListFeature;
use App\Modules\CBT\Features\UnAssignQuestionFromAssessmentFeature;
use App\Modules\CBT\Features\UpdateQuestionFeature;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Models\QuestionModel;
use App\Modules\CBT\Requests\AssignQuestionToAssessmentRequest;
use App\Modules\CBT\Requests\CreateQuestionRequest;
use App\Modules\CBT\Requests\ImportQuestionsRequest;
use App\Modules\CBT\Requests\MassAssignQuestionsRequest;
use App\Modules\CBT\Requests\MassAssignUnQuestionsRequest;
use App\Modules\CBT\Requests\QuestionBankRequest;
use App\Modules\CBT\Requests\QuestionListRequest;
use App\Modules\CBT\Requests\UnAssignQuestionFromAssessmentRequest;
use App\Modules\CBT\Requests\UpdateQuestionRequest;
use App\Modules\SchoolManager\Models\ClassModel;

class QuestionController extends Controller
{
    public function create(AssessmentModel $assessment, CreateQuestionRequest $request)
    {
        return $this->serve( new CreateQuestionFeature( $assessment ), $request->validated() );
    }

    public function update(QuestionModel $question, UpdateQuestionRequest $request)
    {
        return $this->serve( new UpdateQuestionFeature( $question ), $request->validated() );
    }

    public function import(ImportQuestionsRequest $request)
    {
        return $this->serve( new ImportQuestionsFeature(), $request->validated() );
    }

    public function getQuestions(QuestionListRequest $request)
    {
        return $this->serve( new QuestionListFeature(), $request->validated() );
    }

    public function assignQuestionToAssessment( AssessmentModel $assessment,  AssignQuestionToAssessmentRequest $request )
    {
        return $this->serve( new AssignQuestionToAssessmentFeature( $assessment ), $request->validated() );
    }

    public function unAssignQuestionFromAssessment( AssessmentModel $assessment,  UnAssignQuestionFromAssessmentRequest $request )
    {
        return $this->serve( new UnAssignQuestionFromAssessmentFeature( $assessment ), $request->validated() );
    }

    public function getQuestionBank(QuestionBankRequest $request)
    {
        return $this->serve( new QuestionBankFeature(), $request->validated() );
    }

    public function getQuestionTypes()
    {
        return response()->json([
            'data' => QuestionModel::QUESTION_TYPES
        ]);
    }

    public function massAssignQuestions(QuestionBankModel $question_bank, MassAssignQuestionsRequest $request)
    {
        $data = $request->validated();

        $assessment = AssessmentModel::find( $question_bank->assessment_id );

        foreach ( $data['questions'] as $question ) {

            foreach ( json_decode($question_bank->classes, true ) as $classId) {
                
                $assessment->assignQuestion( $question, $question_bank->subject_id, $classId, $data['sectionId'] );
            }
        }

        return response()->json([
            'message' => 'Questions Successfully assigned'
        ]);

    }

    public function massUnassignQuestions(QuestionBankModel $question_bank, MassAssignUnQuestionsRequest $request)
    {
        $data = $request->validated();

        $assessment = AssessmentModel::find( $question_bank->assessment_id );

        foreach ( $data['questions'] as $question ) {

            foreach ( json_decode($question_bank->classes, true ) as $classId) {
                
                $assessment->unAssignQuestion( $question, $classId, $question_bank->subject_id );
            }
        }

        return response()->json([
            'message' => 'Questions Successfully assigned'
        ]);

    }

}
