<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\StudentProfileModel;

class GetStudentDataTasks extends BaseTasks{

    public function downloadStudentData()
    {
        $stundentData = StudentProfileModel::get()->map(fn($student, $index) => [
            'S/N'               =>  $index + 1,
            'STUNDENT NAME'     => "$student->first_name $student->surname",
            'EMAIL'             =>  $student->email,
            'PHONE NUMBER'      =>   $student->phone_no,
            'FORM NO'           =>   $student->student_code,
            'PROGRAM OF STUDY'  =>  $student->program_of_study,
            'LEVEL'             =>  $student->class?->class_name,
            'SESSION'           =>  $student->session?->session,
        ]);

        
    }
    
}