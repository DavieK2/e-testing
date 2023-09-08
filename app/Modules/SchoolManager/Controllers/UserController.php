<?php

namespace App\Modules\SchoolManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolManager\Features\AssignTeacherToClassFeature;
use App\Modules\SchoolManager\Features\AssignTeacherToSubjectFeature;
use App\Modules\SchoolManager\Features\CreateTeacherFeature;
use App\Modules\SchoolManager\Features\GetTeacherAssignedClassFeature;
use App\Modules\SchoolManager\Features\GetTeacherAssignedSubjectFeature;
use App\Modules\SchoolManager\Features\GetTeacherListFeature;
use App\Modules\SchoolManager\Requests\AssignTeacherToClassRequest;
use App\Modules\SchoolManager\Requests\AssignTeacherToSubjectRequest;
use App\Modules\SchoolManager\Requests\CreateTeacherRequest;
use App\Modules\SchoolManager\Requests\GetTeacherListRequest;
use App\Modules\UserManager\Models\UserModel;

class UserController extends Controller
{
    public function teachers(GetTeacherListRequest $request)
    {
        return $this->serve( new GetTeacherListFeature(), $request->validated() );
    }

    public function createTeacher(CreateTeacherRequest $request)
    {
        return $this->serve( new CreateTeacherFeature(), $request->validated() );
    }

    public function assignTeacherToSubject(AssignTeacherToSubjectRequest $request)
    {
        return $this->serve( new AssignTeacherToSubjectFeature(), $request->validated() );
    }

    public function assignTeacherToClass(AssignTeacherToClassRequest $request)
    {
        return $this->serve( new AssignTeacherToClassFeature(), $request->validated() );
    }

    public function getTeacherAssignedSubjects(UserModel $teacher)
    {
        return $this->serve( new GetTeacherAssignedSubjectFeature($teacher) );
    }

    public function getTeacherAssignedClasses(UserModel $teacher)
    {
        return $this->serve( new GetTeacherAssignedClassFeature($teacher) );
    }
}
