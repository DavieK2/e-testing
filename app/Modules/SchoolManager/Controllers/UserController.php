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
use App\Modules\SchoolManager\Requests\AssignTeacherToClassSubjectRequest;
use App\Modules\SchoolManager\Requests\AssignTeacherToSubjectRequest;
use App\Modules\SchoolManager\Requests\CreateTeacherRequest;
use App\Modules\SchoolManager\Requests\GetTeacherListRequest;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function updateTeacher( CreateTeacherRequest $request, UserModel $teacher  )
    { 

        $data =  $request->validated();

        $teacher->update( [
            'fullname'  => $data['name'],
            'email'     => $data['email'],
            'phone_no'  => $data['phoneNumber'],
        ] );

        if( $data['password'] ) $teacher->update( ['password' => Hash::make( $data['password'] ) ] );

        return response()->json(['message' => 'Teacher info successfully updated'] );

    }

    public function assignTeacherToSubject(AssignTeacherToSubjectRequest $request)
    {
        return $this->serve( new AssignTeacherToSubjectFeature(), $request->validated() );
    }

    public function assignTeacherToClass(AssignTeacherToClassRequest $request)
    {
        return $this->serve( new AssignTeacherToClassFeature(), $request->validated() );
    }

    public function assignTeacherToClassSubjects(AssignTeacherToClassSubjectRequest $request)
    {

        $data = $request->validated();

        $teacher = UserModel::find($data['teacherId']);

        $teacher->assignToClassSubjects( $data['classSubjects'] );

        return response()->json(['message' => 'Successfully Assigned'] );

    }

    public function getTeacherAssignedSubjects(UserModel $teacher)
    {
        return $this->serve( new GetTeacherAssignedSubjectFeature($teacher) );
    }

    public function getTeacherAssignedClasses(UserModel $teacher)
    {
        return $this->serve( new GetTeacherAssignedClassFeature($teacher) );
    }

    public function getTeacherAssignedClassSubjects(UserModel $teacher)
    {
        $subjects = DB::table('user_class_subjects')
                    ->where('user_id', $teacher->uuid)
                    ->join('classes', 'classes.uuid', '=', 'user_class_subjects.class_id')
                    ->select('user_class_subjects.subject_id', 'classes.class_code')
                    ->get()
                    ->groupBy('subject_id')
                    ->mapWithKeys(fn($value, $key) => [ $key => $value->pluck('class_code')])
                    ->toArray();

        return response()->json(['data' => $subjects ]);
    }

    
}
