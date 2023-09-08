<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Features\GetTeacherAssessmentQuestionFeature;
use App\Modules\CBT\Features\GetTeacherClassSubjectsFeature;
use App\Modules\CBT\Requests\GetTeacherAssessmentQuestionRequest;
use App\Modules\SchoolManager\Features\GetTeacherAssignedClassFeature;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\UserManager\Models\UserModel;

class TeacherController extends Controller
{
    public function getClasses()
    {
        return $this->serve( new GetTeacherAssignedClassFeature( UserModel::find(3) ));
    }

    public function getSubjects(ClassModel $class)
    {
        return $this->serve( new GetTeacherClassSubjectsFeature( UserModel::find(3), $class ) );
    }

    public function getAssessmentQuestions(GetTeacherAssessmentQuestionRequest $request)
    {
        return $this->serve( new GetTeacherAssessmentQuestionFeature(), $request->validated() );
    }
}
