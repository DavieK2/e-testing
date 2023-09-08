<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Support\Str;

class CreateStudentTasks extends BaseTasks{

    public function createStudent()
    {
        $count = StudentProfileModel::count() + 1;
        $student_code = 'JEPH-'.str_pad(strval($count), 4, '0', STR_PAD_LEFT).'-'.Str::random(4);

        $student = StudentProfileModel::create([
            'first_name'     =>  $this->item['firstName'],
            'surname'       =>  $this->item['surname'],
            'class_id'      =>  $this->item['classId'],
            'student_code'  =>  strtoupper($student_code)
        ]);

        return new static( [ ...$this->item, 'student' => $student ]);
    }
    
}