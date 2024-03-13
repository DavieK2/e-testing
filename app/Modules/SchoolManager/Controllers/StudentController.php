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
use App\Modules\SchoolManager\Requests\MassAssignSubjectsToStudentsRequest;
use App\Modules\SchoolManager\Requests\StudentListRequest;
use App\Modules\SchoolManager\Requests\UpdateStudentProfileRequest;
use Illuminate\Support\Str;

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
        
        $student = StudentProfileModel::firstWhere('uuid', $data['studentId']);

        $student->update(['first_name' => $data['firstName'], 'surname' => $data['surname'], 'class_id' => $data['classId'], 'profile_pic' => $data['profilePic'] ?? null, 'student_code' => $data['studentCode'] ?? null ]);

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
            'uuid' => Str::ulid(),
            'first_name' => $data['firstName'],
            'surname' => $data['lastName'],
            'student_code' => $data['regNo'],
            'reg_no' => $data['regNo'],
            'profile_pic' => $data['profilePic'],
            'class_id' => $data['level'],
            'email' => $data['email'],
            'session' => $data['session'],
            'program_of_study' => $data['programOfStudy'],
            'academic_session_id' => $data['session'],
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function massAssignSubjectsToStudents(MassAssignSubjectsToStudentsRequest $request)
    {
        $data = $request->validated();

        foreach ( $data['students'] as $student ) {
            
            StudentProfileModel::find( $student )->assignSubject( $data['subjects'] );
        }

        return response()->json(['message' => 'Success']);

    }
}
