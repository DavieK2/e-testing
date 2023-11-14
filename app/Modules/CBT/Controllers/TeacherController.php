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
    public function getClasses()
    {
        return $this->serve( new GetTeacherAssignedClassFeature( request()->user() ));
    }

    public function getSubjects()
    {
        return $this->serve( new GetTeacherClassSubjectsFeature( request()->user() ) );
    }

    public function getClassSubjects(SubjectModel $subject)
    {
        $classes = DB::table('user_class_subjects')
                    ->where( fn( $query ) => $query->where('user_id', request()->user()->id)->where('subject_id', $subject->id ))
                    ->join('classes', 'classes.id', '=', 'user_class_subjects.class_id')
                    ->select('classes.class_name', 'classes.class_code')
                    ->orderBy('classes.class_name', 'asc')
                    ->get()
                    ->toArray();

        return response()->json(['data' => $classes]);
    }

    public function getAssessmentQuestions( QuestionBankModel $question_bank )
    {
        return $this->serve( new GetTeacherAssessmentQuestionFeature( $question_bank ) );
    }
}
