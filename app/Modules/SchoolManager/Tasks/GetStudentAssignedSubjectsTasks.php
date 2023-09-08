<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;

class GetStudentAssignedSubjectsTasks extends BaseTasks{

    public function getAssignedSubjects()
    {
        $subjects = $this->item->subjects();

        return new static( ['query' => $subjects ] );
    }
    
}