<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\GetTeacherAssessmentQuestionFeature;
use App\Modules\CBT\Features\GetTeacherClassSubjectsFeature;
use App\Modules\CBT\Requests\GetTeacherAssessmentQuestionRequest;
use App\Modules\SchoolManager\Features\GetTeacherAssignedClassFeature;
use App\Modules\SchoolManager\Models\ClassModel;

class TeacherController extends Controller
{
    public function getClasses()
    {
        return $this->serve( new GetTeacherAssignedClassFeature( request()->user() ));
    }

    public function getSubjects(ClassModel $class)
    {
        return $this->serve( new GetTeacherClassSubjectsFeature( request()->user(), $class ) );
    }

    public function getAssessmentQuestions(GetTeacherAssessmentQuestionRequest $request)
    {
        return $this->serve( new GetTeacherAssessmentQuestionFeature(), $request->validated() );
    }
}
