<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\SchoolManager\Models\ClassModel;

class AssignSubjectToClassTask extends BaseTasks{

    public function assignSubjects()
    {
        $class = ClassModel::find($this->item['classId']);

        $class->assignSubjects(collect($this->item['subjects'])->pluck('subjectId')->toArray());

        return new static( $this->item );
    }
    
}