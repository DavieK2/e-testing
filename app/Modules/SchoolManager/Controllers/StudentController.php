<?php

namespace App\Modules\SchoolManager\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Excel\Export;
use App\Modules\SchoolManager\Features\AssignSubjectToStudentFeature;
use App\Modules\SchoolManager\Features\CreateStudentFeature;
use App\Modules\SchoolManager\Features\DownloadStudentDataFeature;
use App\Modules\SchoolManager\Features\GetStudentAssignedSubjectsFeature;
use App\Modules\SchoolManager\Features\ImportStudentDataFromFileFeature;
use App\Modules\SchoolManager\Features\StudentListFeature;
use App\Modules\SchoolManager\Features\UpdateStudentFeature;
use App\Modules\SchoolManager\Features\UploadStudentsFeature;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use App\Modules\SchoolManager\Requests\AssignSubjectToStudentRequest;
use App\Modules\SchoolManager\Requests\CreateStudentRequest;
use App\Modules\SchoolManager\Requests\CreateSudentProfileRequest;
use App\Modules\SchoolManager\Requests\DownloadStudentDataRequest;
use App\Modules\SchoolManager\Requests\ImportStudentDataFromFileRequest;
use App\Modules\SchoolManager\Requests\MassAssignSubjectsToStudentsRequest;
use App\Modules\SchoolManager\Requests\StudentListRequest;
use App\Modules\SchoolManager\Requests\UpdateStudentProfileRequest;
use App\Modules\SchoolManager\Requests\UploadStudentsRequest;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

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

    public function update(StudentProfileModel $student, UpdateStudentProfileRequest $request)
    {
        return $this->serve( new UpdateStudentFeature($student), $request->validated() );
    }

    public function assignStudentToSubject(StudentProfileModel $student, AssignSubjectToStudentRequest $request)
    {
        return $this->serve( new AssignSubjectToStudentFeature($student), $request->validated() );
    }

    public function getStudentAssignedSubjects(StudentProfileModel $student)
    {
        return $this->serve( new GetStudentAssignedSubjectsFeature($student) ) ;
    }

    public function upload( UploadStudentsRequest $request )
    {
        return $this->serve( new UploadStudentsFeature(), $request->validated() );
    }

    public function import ( ImportStudentDataFromFileRequest $request)
    {
        return $this->serve( new ImportStudentDataFromFileFeature(), $request->validated() );
    }

    public function downloadStudentData( DownloadStudentDataRequest $request )
    {

        $stundentData = StudentProfileModel::get()->map(fn($student, $index) => [
            'S/N'               =>  $index + 1,
            'STUNDENT NAME'     => "$student->first_name $student->surname",
            'EMAIL'             =>  $student->email,
            'PHONE NUMBER'      =>  $student->phone_no,
            'FORM NO'           =>  $student->student_code,
            'PROGRAM OF STUDY'  =>  $student->program_of_study,
            'LEVEL'             =>  $student->class?->class_name,
            'SESSION'           =>  $student->session?->session,
        ]);

        $headings = ['S/N','STUNDENT NAME', 'EMAIL', 'PHONE NUMBER', 'FORM NO', 'PROGRAM OF STUDY', 'LEVEL', 'SESSION'];

        return Excel::download( new Export( $stundentData, $headings), "STUDENTS_DATA.xlsx" );
        
    }

    public function createStudentProfile(CreateSudentProfileRequest $request)
    {
        $data = $request->validated();

        $image = Image::make($data['profilePic']);

        $image->resize(800, null, fn ($constraint) => $constraint->aspectRatio() );

        $student_code = $data['regNo'];

        $student_code = str_replace('/', '-', $student_code);

        $pic_name = "profile_pics/".$student_code.".jpg";

        $image->save(public_path($pic_name));
        
        StudentProfileModel::create([
            'uuid' => Str::ulid(),
            'first_name' => $data['firstName'],
            'surname' => $data['lastName'],
            'student_code' => $data['regNo'],
            'reg_no' => $data['regNo'],
            'profile_pic' => $data['profilePic'],
            'class_id' => $data['level'],
            'email' => $data['email'] ?? null,
            'phone_no' => $data['phoneNo'] ?? null,
            'session' => $data['session'],
            'program_of_study' => $data['programOfStudy'] ?? null,
            'academic_session_id' => $data['session'],
        ]);

        return response()->json(['message' => 'Success']);
    }

    public function massAssignSubjectsToStudents(MassAssignSubjectsToStudentsRequest $request)
    {
        set_time_limit(0);

        $data = $request->validated();

        $students = LazyCollection::make($data['students']);

        $students->each( fn($student) =>  StudentProfileModel::find( $student )->assignSubject( $data['subjects'] ) );
       
        return response()->json(['message' => 'Success']);

    }
}
