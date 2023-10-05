<?php

namespace App\Modules\SchoolManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SchoolManager\Features\AssignSubjectToStudentFeature;
use App\Modules\SchoolManager\Features\CreateStudentFeature;
use App\Modules\SchoolManager\Features\GetStudentAssignedSubjectsFeature;
use App\Modules\SchoolManager\Features\StudentListFeature;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Requests\AssignSubjectToStudentRequest;
use App\Modules\SchoolManager\Requests\CreateStudentRequest;
use App\Modules\SchoolManager\Requests\CreateSudentProfileRequest;
use App\Modules\SchoolManager\Requests\StudentListRequest;
use App\Modules\SchoolManager\Requests\UpdateStudentProfileRequest;

class StudentController extends Controller
{
    public function index(StudentListRequest $request)
    {
        return $this->serve( new StudentListFeature(), $request->validated() );
    }

    public function create(CreateStudentRequest $request)
    {
        return $this->serve( new CreateStudentFeature(), $request->validated() );
    }

    public function update(UpdateStudentProfileRequest $request)
    {
        $data = $request->validated();

        $student = StudentProfileModel::find($data['studentId']);

        $student->update(['first_name' => $data['firstName'], 'surname' => $data['surname'], 'class_id' => $data['classId'], 'profile_pic' => $data['profilePic'] ?? null ]);

        return response()->json(['message' => 'Success']);
    }

    public function assignStudentToSubject(AssignSubjectToStudentRequest $request)
    {
        return $this->serve( new AssignSubjectToStudentFeature(), $request->validated() );
    }

    public function getStudentAssignedSubjects(StudentProfileModel $student)
    {
        return $this->serve( new GetStudentAssignedSubjectsFeature($student) ) ;
    }

    public function createStudentProfile(CreateSudentProfileRequest $request)
    {
        $data = $request->validated();

        StudentProfileModel::create([
            'first_name' => $data['firstName'],
            'surname' => $data['lastName'],
            'student_code' => $data['regNo'],
            'reg_no' => $data['regNo'],
            'profile_pic' => $data['profilePic'],
            'class_id' => $data['level'],
        ]);

        return response()->json(['message' => 'Success']);
    }
}
