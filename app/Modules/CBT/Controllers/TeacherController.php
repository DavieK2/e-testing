<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\GetTeacherAssessmentQuestionFeature;
use App\Modules\CBT\Features\GetTeacherClassSubjectsFeature;
use App\Modules\CBT\Models\QuestionBankModel;
use App\Modules\CBT\Requests\GetTeacherAssessmentQuestionRequest;
use App\Modules\SchoolManager\Features\GetTeacherAssignedClassFeature;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function getAssessmentQuestions( QuestionBankModel $question_bank )
    {
        return $this->serve( new GetTeacherAssessmentQuestionFeature( $question_bank ) );
    }
}
