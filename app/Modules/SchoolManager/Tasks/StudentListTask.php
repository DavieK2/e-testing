<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\StudentProfileModel;

class StudentListTask extends BaseTasks{

    public function getStudents()
    {
        $students = StudentProfileModel::query()->select('id', 'class_id', 'student_code', 'first_name', 'surname');

        return new static([ ...$this->item, 'query' => $students ]);
    }
    
}