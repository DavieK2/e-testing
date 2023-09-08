<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\StudentProfileModel;

class AssignSubjectToStudentTasks extends BaseTasks{

    public function assignSubjectToStudent()
    {
        $student = StudentProfileModel::find($this->item['studentId']);

        $student->assignSubject( collect($this->item['subjects'])->pluck('subjectId')->toArray() );

        return new static( $this->item );
    }
    
}