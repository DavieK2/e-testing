<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\UserManager\Models\UserModel;

class AssignTeacherToSubjectTask extends BaseTasks{

    public function assignTeacherToSubject()
    {
        $teacher = UserModel::find($this->item['teacherId']);

        $teacher->assignToSubject( collect($this->item['subjects'])->pluck('subjectId')->toArray() );

        return new static( $this->item );
    }
    
}