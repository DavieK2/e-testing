<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\AssignQuestionToAssessmentFeature;
use App\Modules\CBT\Features\CreateQuestionFeature;
use App\Modules\CBT\Features\QuestionBankFeature;
use App\Modules\CBT\Features\QuestionListFeature;
use App\Modules\CBT\Features\UnAssignQuestionFromAssessmentFeature;
use App\Modules\CBT\Features\UpdateQuestionFeature;
use App\Modules\CBT\Models\AssessmentModel;
use App\Modules\CBT\Requests\AssignQuestionToAssessmentRequest;
use App\Modules\CBT\Requests\CreateQuestionRequest;
use App\Modules\CBT\Requests\QuestionBankRequest;
use App\Modules\CBT\Requests\QuestionListRequest;
use App\Modules\CBT\Requests\UnAssignQuestionFromAssessmentRequest;
use App\Modules\CBT\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{
    public function create(AssessmentModel $assessment, CreateQuestionRequest $request)
    {
        return $this->serve( new CreateQuestionFeature( $assessment ), $request->validated() );
    }

    public function update(AssessmentModel $assessment, UpdateQuestionRequest $request)
    {
        return $this->serve( new UpdateQuestionFeature( $assessment ), $request->validated() );
    }

    public function getQuestions(AssessmentModel $assessment, QuestionListRequest $request)
    {
        return $this->serve( new QuestionListFeature( $assessment ), $request->validated() );
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
}
