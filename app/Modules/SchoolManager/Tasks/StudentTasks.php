<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentTasks extends BaseTasks{

    protected StudentProfileModel|null $student = null;

    public function getStudents() : static
    {
        $students = StudentProfileModel::query()->select('uuid', 'class_id', 'student_code', 'first_name', 'surname', 'profile_pic');

        if( isset( $this->item['classId'] ) ){

           $students->where( 'class_id', $this->item['classId'] );
        }

        return new static([ ...($this->item ?? []), 'query' => $students ]);
    }

    public function downloadStudentData()
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
    }

    public function student( StudentProfileModel $student ) : static
    {  
        if( ! $student->exists ) throw new ModelNotFoundException();

        $this->student = $student;

        return $this;
    }

    public function getAssignedSubjects() : static
    {
        $subjects = $this->student->subjects();

        return new static( ['query' => $subjects ] );
    }

    public function assignSubjectToStudent() : static
    {

        $this->student->assignSubject( $this->item['subjects'] );

        return new static( $this->item );
    }

    public function updateProfile()
    {
        $this->student->update([
            'first_name'     => $this->item['firstName'], 
            'surname'       => $this->item['surname'], 
            'class_id'      => $this->item['classId'], 
            'profile_pic'    => $this->item['profilePic'] ?? null, 
            'student_code'  => $this->item['studentCode'] ?? null 
        ]);

        return new static( $this->item );

    }
    
}